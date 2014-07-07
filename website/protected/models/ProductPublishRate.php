<?php

/**
 * This is the model class for table "product_publish_rate".
 *
 * The followings are the available columns in table 'product_publish_rate':
 * @property integer $publish_rate_id
 * @property integer $product_id
 * @property integer $money
 * @property double $min_rate
 * @property double $max_rate
 *
 * The followings are the available model relations:
 * @property ProductInfo $product
 */
class ProductPublishRate extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_publish_rate';
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
			'publish_rate_id' => 'Publish Rate',
			'product_id' => 'Product',
			'money' => '金额(万)',
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

		$criteria->compare('publish_rate_id',$this->publish_rate_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('money',$this->money);
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
	 * @return ProductPublishRate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
