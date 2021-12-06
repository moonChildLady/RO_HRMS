<?php

/**
 * This is the model class for table "LeaveBalance".
 *
 * The followings are the available columns in table 'LeaveBalance':
 * @property integer $id
 * @property string $staffCode
 * @property string $balanceDate
 * @property double $balance
 *
 * The followings are the available model relations:
 * @property Staff $staffCode0
 */
class LeaveBalance extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $Fullname;
	
	public function tableName()
	{
		return 'LeaveBalance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staffCode, balanceDate, balance', 'required'),
			array('balance', 'numerical'),
			array('staffCode', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, balanceDate, balance, Fullname', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'staffCode0' => array(self::BELONGS_TO, 'Staff', 'staffCode'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'staffCode' => 'Staff Code',
			'balanceDate' => 'Balance Date',
			'balance' => 'Balance',
			'Fullname' => 'Fullname',
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
		$sort = new CSort();
		$criteria->with = array("staffCode0");
		$criteria->compare('id',$this->id);
		$criteria->compare('t.staffCode',$this->staffCode,true);
		$criteria->compare('balanceDate',$this->balanceDate,true);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('concat(staffCode0.surName, " ",staffCode0.givenName)',$this->Fullname,true);
		$sort->defaultOrder= array(
			'concat(staffCode0.surName, " ",staffCode0.givenName)'=>CSort::SORT_ASC,
			//'id'=>CSort::SORT_ASC,
			
            
        );
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LeaveBalance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
