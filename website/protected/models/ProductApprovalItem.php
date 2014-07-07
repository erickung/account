<?php

/**
 * This is the model class for table "product_approval_item".
 *
 * The followings are the available columns in table 'product_approval_item':
 * @property integer $pai_id
 * @property integer $product_id
 * @property integer $after_status
 * @property integer $origin_status
 * @property integer $type
 * @property string $note
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property ProductInfo $product
 * @property User $user
 */
class ProductApprovalItem extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_approval_item';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'product' => array(self::BELONGS_TO, 'ProductInfo', 'product_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pai_id' => 'Pai',
			'product_id' => 'Product',
			'after_status' => 'After Status',
			'origin_status' => 'Origin Status',
			'type' => '通过/驳回',
			'note' => 'Note',
			'user_id' => 'User',
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

		$criteria->compare('pai_id',$this->pai_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('after_status',$this->after_status);
		$criteria->compare('origin_status',$this->origin_status);
		$criteria->compare('type',$this->type);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductApprovalItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
