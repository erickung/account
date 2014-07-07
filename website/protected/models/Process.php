<?php

/**
 * This is the model class for table "process".
 *
 * The followings are the available columns in table 'process':
 * @property integer $process_id
 * @property string $process_name
 *
 * The followings are the available model relations:
 * @property ProductRole[] $productRoles
 * @property ProductInfo[] $productInfos
 */
class Process extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'process';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'productRoles' => array(self::MANY_MANY, 'ProductRole', 'process_roles(process_id, role_id)'),
			'productInfos' => array(self::HAS_MANY, 'ProductInfo', 'process_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'process_id' => 'Process',
			'process_name' => 'Process Name',
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

		$criteria->compare('process_id',$this->process_id);
		$criteria->compare('process_name',$this->process_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Process the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
