<?php

/**
 * This is the model class for table "product_publish".
 *
 * The followings are the available columns in table 'product_publish':
 * @property integer $product_id
 * @property integer $personal_threshold
 * @property integer $origin_threshold
 * @property integer $start_date
 * @property integer $end_date
 * @property string $bank_account
 * @property string $bank_name
 * @property string $bank_address
 *
 * The followings are the available model relations:
 * @property ProductInfo $product
 */
class ProductPublish extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_publish';
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
			'personal_threshold' => '个人投资起点',
			'origin_threshold' => '机构投资起点',
			'start_date' => '发行开始时间',
			'end_date' => '发行结束时间',
			'bank_account' => '开户行账号',
			'bank_name' => '开户行户名',
			'bank_address' => '开户行',
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
		$criteria->compare('personal_threshold',$this->personal_threshold);
		$criteria->compare('origin_threshold',$this->origin_threshold);
		$criteria->compare('start_date',$this->start_date);
		$criteria->compare('end_date',$this->end_date);
		$criteria->compare('bank_account',$this->bank_account,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('bank_address',$this->bank_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductPublish the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
