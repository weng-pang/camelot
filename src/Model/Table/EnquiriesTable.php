<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Enquiries Model
 *
 * @method \App\Model\Entity\Enquiry get($primaryKey, $options = [])
 * @method \App\Model\Entity\Enquiry newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Enquiry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Enquiry|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Enquiry|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Enquiry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Enquiry[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Enquiry findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EnquiriesTable extends Table
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

        $this->setTable('enquiries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
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
            ->scalar('subject')
            ->maxLength('subject', 65)
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->scalar('body')
            ->maxLength('body', 255)
            ->requirePresence('body', 'create')
            ->notEmpty('body');

        $validator
            ->scalar('temp_email')
            ->maxLength('temp_email', 255)
            ->requirePresence('temp_email', 'create')
            ->notEmpty('temp_email');

        return $validator;
    }
}
