<?php

/**
 * This is the model class for table "timeSlotStaff".
 *
 * The followings are the available columns in table 'timeSlotStaff':
 * @property integer $id
 * @property string $staffCode
 * @property integer $timeSlotGroup
 * @property string $startDate
 * @property string $endDate
 * @property string $status
 * @property string $createDate
 *
 * The followings are the available model relations:
 * @property TimeSlotAissigment $timeSlotGroup0
 * @property Staff $staffCode0
 */
class TimeSlotStaff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'timeSlotStaff';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('staffCode, timeSlotGroup, startDate, endDate, createDate', 'required'),
			array('timeSlotGroup', 'numerical', 'integerOnly'=>true),
			array('staffCode', 'length', 'max'=>100),
			array('status', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, timeSlotGroup, startDate, endDate, status, createDate', 'safe', 'on'=>'search'),
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
			'timeSlotGroup0' => array(self::BELONGS_TO, 'TimeSlotAissigment', 'timeSlotGroup'),
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
			'timeSlotGroup' => 'Time Slot Group',
			'startDate' => 'Start Date',
			'endDate' => 'End Date',
			'status' => 'Status',
			'createDate' => 'Create Date',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('staffCode',$this->staffCode,true);
		$criteria->compare('timeSlotGroup',$this->timeSlotGroup);
		$criteria->compare('startDate',$this->startDate,true);
		$criteria->compare('endDate',$this->endDate,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('createDate',$this->createDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TimeSlotStaff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
