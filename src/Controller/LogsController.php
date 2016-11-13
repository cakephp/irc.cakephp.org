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
        $this->set('channels', $this->Channels->find()->all());
    }

    /**
     * View method
     *
     * @param mixed $channel
     * @return \Cake\Network\Response|null
     */
    public function view($channel = null)
    {
        if ($this->request->query('page', 1) > 50) {
            return $this->redirect('/');
        }

        $this->Crud->on('beforePaginate', function (Event $event) use ($channel) {
            $repository = $event->subject()->query->repository();

            $this->paginate['conditions'] = [
                sprintf('%s.channel', $repository->alias()) => "#${channel}"
            ];
            $this->paginate['limit'] = 100;
            $this->paginate['order'] = [
                sprintf('%s.created', $repository->alias()) => 'desc'
            ];
        });

        $this->set(['channel' => $channel]);
        return $this->Crud->execute();
    }

    /**
     * Search method
     *
     * @return \Cake\Network\Response|null
     */
    public function search($channel = null, $term = null)
    {
        if (!empty($this->request->data)) {
            return $this->redirect([
                $this->request->data('Search.channel'),
                urlencode($this->request->data('Search.query')),
            ]);
        }

        $this->Flash->set('Matching "' . htmlspecialchars($term) . '"');
        $this->Crud->on('beforePaginate', function (Event $event) use ($channel, $term) {
            $repository = $event->subject()->query->repository();
            if (strpos($term, '%') === false) {
                $term = '%' . $term . '%';
            }

            $this->paginate['conditions'] = [
                sprintf('%s.channel', $repository->alias()) => "#${channel}",
                'OR' => [
                    sprintf('%s.username LIKE', $repository->alias()) => $term,
                    sprintf('%s.text LIKE', $repository->alias()) => $term,
                ],
            ];
            $this->paginate['limit'] = 100;
            $this->paginate['order'] = [
                sprintf('%s.created', $repository->alias()) => 'desc'
            ];
        });

        $this->set(['channel' => $channel]);
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

        $first = $this->Logs->find()
                            ->where(['channel' => $log->channel, 'id >=' => $id])
                            ->offset($offset)
                            ->order(['id' => 'ASC'])
                            ->first();
        if (!$first) {
            $first = $this->Logs->find()
                    ->where(['channel' => $log->channel, 'id >=' => $id])
                    ->order(['id' => 'DESC'])
                    ->first();
        }
        $last = $this->Logs->find()
                           ->where(['channel' => $log->channel, 'id <=' => $id])
                           ->offset($offset)
                           ->order(['id' => 'DESC'])
                           ->first();
        if (!$last) {
            $last = $this->Logs->find()
                               ->where(['channel' => $log->channel, 'id <=' => $id])
                               ->order(['id' => 'ASC'])
                               ->first();
        }

        $this->paginate['limit'] = $offset * 3;
        $this->paginate['conditions'] = [
            'channel' => $log->channel,
            'id <=' => $first->id,
            'id >=' => $last->id,
        ];

        $this->set([
            'log' => $log,
            'logs' => $this->paginate('Logs'),
            'highlight' => $id,
            'wrap' => $wrap,
        ]);
        $this->render('view');
    }
}
