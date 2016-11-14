<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Logs Controller
 *
 * @property \App\Model\Table\LogsTable $Logs
 */
class LogsController extends AppController
{

    /**
     * A list of actions where the Crud.SearchListener
     * and Search.PrgComponent should be enabled
     *
     * @var array
     */
    protected $searchActions = ['view'];

    /**
     * Before filter callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['link']);
        $this->loadModel('Channels');
        $this->Crud->mapAction('search', [
            'className' => 'Crud.Index',
            'view' => 'view',
        ]);
        $this->Crud->mapAction('view', ['className' => 'Crud.Index']);
        $this->Crud->disable(['add', 'edit', 'delete']);
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $channels = $this->Channels->find()
                                   ->where(['enabled' => true])
                                   ->all();
        $this->set('channels', $channels);
        $this->set('_serialize', ['channels']);
    }

    /**
     * View method
     *
     * @param mixed $channel
     * @return \Cake\Network\Response|null
     */
    public function view($channelName = null)
    {
        if ($this->request->query('page', 1) > 50) {
            return $this->redirect('/');
        }

        $channel = $this->Channels->find()
                                  ->where([
                                        'name' => "#${channelName}",
                                        'enabled' => true,
                                    ])
                                  ->first();
        if (empty($channel)) {
            return $this->redirect('/');
        }

        $this->Crud->on('beforePaginate', function (Event $event) use ($channel) {
            $repository = $event->subject()->query->repository();
            $this->paginate['limit'] = 100;
            $event->subject()->query->where([
                                        sprintf('%s.channel_id', $repository->alias()) => $channel->id,
                                    ])
                                    ->contain([])
                                    ->limit(100)
                                    ->order([
                                        sprintf('%s.created', $repository->alias()) => 'desc',
                                    ]);
        });

        $this->set(['channel' => $channel->name]);
        return $this->Crud->execute();
    }

    /**
     * Link method
     *
     * 'perma' link to an individual message
     *
     * @param mixed $id
     * @return void
     * @return \Cake\Network\Response|null
     */
    public function link($id = null, $wrap = null) {
        $offset = $wrap;
        if (!$offset) {
            $offset = 20;
        }
        if ($offset > 50) {
            return $this->redirect('/');
        }
        if (!$id) {
            return $this->redirect($this->referer('/', true));
        }

        $log = $this->Logs->find()->where(['id' => $id])->first();
        if (!$log) {
            return $this->redirect($this->referer('/', true));
        }

        $channel = $this->Channels->find()
                          ->where([
                                'id' => $log->channel_id,
                                'enabled' => true,
                            ])
                          ->first();
        if (empty($channel)) {
            return $this->redirect('/');
        }

        $first = $this->Logs->find()
                            ->where(['channel_id' => $log->channel_id, 'id >=' => $id])
                            ->offset($offset)
                            ->order(['id' => 'ASC'])
                            ->first();
        if (!$first) {
            $first = $this->Logs->find()
                    ->where(['channel_id' => $log->channel_id, 'id >=' => $id])
                    ->order(['id' => 'DESC'])
                    ->first();
        }
        $last = $this->Logs->find()
                           ->where(['channel_id' => $log->channel_id, 'id <=' => $id])
                           ->offset($offset)
                           ->order(['id' => 'DESC'])
                           ->first();
        if (!$last) {
            $last = $this->Logs->find()
                               ->where(['channel_id' => $log->channel_id, 'id <=' => $id])
                               ->order(['id' => 'ASC'])
                               ->first();
        }

        $logs = $this->Logs->find()
                           ->where([
                               'channel_id' => $log->channel_id,
                               'id <=' => $first->id,
                               'id >=' => $last->id,
                           ])
                           ->limit($offset * 3)
                           ->order(['id' => 'DESC']);
        $this->set([
            'log' => $log,
            'logs' => $logs,
            'highlight' => $id,
            'wrap' => $wrap,
        ]);
        return $this->render('view');
    }
}
