<?php

/**
 * This is the model class for table "product_role".
 *
 * The followings are the available columns in table 'product_role':
 * @property integer $pr_id
 * @property string $pr_name
 *
 * The followings are the available model relations:
 * @property Process[] $processes
 * @property ProductApprovalItem[] $productApprovalItems
 * @property User[] $users
 */
class ProductRole extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_role';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'processes' => array(self::MANY_MANY, 'Process', 'process_roles(role_id, process_id)'),
			'productApprovalItems' => array(self::HAS_MANY, 'ProductApprovalItem', 'pr_id'),
			'users' => array(self::MANY_MANY, 'User', 'user_product_role(pr_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pr_id' => 'Pr',
			'pr_name' => 'Pr Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pr_id',$this->pr_id);
		$criteria->compare('pr_name',$this->pr_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductRole the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
