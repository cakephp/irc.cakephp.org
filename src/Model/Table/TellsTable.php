<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tells Model
 *
 * @method \App\Model\Entity\Tell get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tell newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tell[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tell|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tell patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tell[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tell findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TellsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('tells');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Search.Search');
        $this->addBehavior('Timestamp');
        $this->searchManager()
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['keyword', 'message'],
            ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('keyword', 'create')
            ->notEmpty('keyword');

        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        return $validator;
    }
}
