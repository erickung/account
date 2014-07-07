<?php

/**
 * This is the model class for table "product_info".
 *
 * The followings are the available columns in table 'product_info':
 * @property integer $product_id
 * @property string $name
 * @property integer $type
 * @property integer $fund_size
 * @property integer $build_date
 * @property string $funds_source
 * @property integer $status
 * @property integer $process_id
 * @property integer $duration
 * @property integer $investment_way
 * @property double $min_rate
 * @property double $max_rate
 *
 * The followings are the available model relations:
 * @property CustomerPurchase[] $customerPurchases
 * @property ProductAccountInformation $productAccountInformation
 * @property ProductApprovalItem[] $productApprovalItems
 * @property ProductExtra $productExtra
 * @property ProductFiles[] $productFiles
 * @property Process $process
 * @property ProductPublish $productPublish
 * @property ProductPublishRate[] $productPublishRates
 * @property ProductReturnRate[] $productReturnRates
 */
class ProductInfo extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_info';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'customerPurchases' => array(self::HAS_MANY, 'CustomerPurchase', 'product_id'),
			'productAccountInformation' => array(self::HAS_ONE, 'ProductAccountInformation', 'product_id'),
			'productApprovalItems' => array(self::HAS_MANY, 'ProductApprovalItem', 'product_id'),
			'productExtra' => array(self::HAS_ONE, 'ProductExtra', 'product_id'),
			'productFiles' => array(self::HAS_MANY, 'ProductFiles', 'product_id'),
			'process' => array(self::BELONGS_TO, 'Process', 'process_id'),
			'productPublish' => array(self::HAS_ONE, 'ProductPublish', 'product_id'),
			'productPublishRates' => array(self::HAS_MANY, 'ProductPublishRate', 'product_id'),
			'productReturnRates' => array(self::HAS_MANY, 'ProductReturnRate', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'product_id' => 'Product',
			'name' => '项目名称',
			'type' => '信托类型',
			'fund_size' => '发行规模',
			'build_date' => '成立日期',
			'funds_source' => '资金来源',
			'status' => 'Status',
			'process_id' => '流程id',
			'duration' => '项目期限',
			'investment_way' => '投资方式',
			'min_rate' => 'Min Rate',
			'max_rate' => 'Max Rate',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('fund_size',$this->fund_size);
		$criteria->compare('build_date',$this->build_date);
		$criteria->compare('funds_source',$this->funds_source,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('process_id',$this->process_id);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('investment_way',$this->investment_way);
		$criteria->compare('min_rate',$this->min_rate);
		$criteria->compare('max_rate',$this->max_rate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
