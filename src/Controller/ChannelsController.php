<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Channels Controller
 *
 * @property \App\Model\Table\ChannelsTable $Channels
 */
class ChannelsController extends AppController
{

    /**
     * Before filter callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $this->Crud->disable(['view', 'add', 'edit', 'delete']);
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
}
