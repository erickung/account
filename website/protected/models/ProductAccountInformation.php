<?php

/**
 * This is the model class for table "product_account_information".
 *
 * The followings are the available columns in table 'product_account_information':
 * @property integer $product_id
 * @property string $account_name
 * @property string $account_number
 * @property string $account_bank
 *
 * The followings are the available model relations:
 * @property ProductInfo $product
 */
class ProductAccountInformation extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_account_information';
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'product_id' => 'Product',
			'account_name' => 'Account Name',
			'account_number' => 'Account Number',
			'account_bank' => 'Account Bank',
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

		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('account_name',$this->account_name,true);
		$criteria->compare('account_number',$this->account_number,true);
		$criteria->compare('account_bank',$this->account_bank,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductAccountInformation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
