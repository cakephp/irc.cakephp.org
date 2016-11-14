<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Tells Controller
 *
 * @property \App\Model\Table\TellsTable $Tells
 */
class TellsController extends AppController
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
}
