<?php

/**
 * This is the model class for table "timeSlot".
 *
 * The followings are the available columns in table 'timeSlot':
 * @property integer $id
 * @property string $timeslotName
 * @property string $startTime
 * @property string $endTime
 *
 * The followings are the available model relations:
 * @property TimeSlotAissigment[] $timeSlotAissigments
 */
class TimeSlot extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'timeSlot';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('timeslotName, startTime, endTime', 'required'),
			array('timeslotName', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, timeslotName, startTime, endTime', 'safe', 'on'=>'search'),
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
			'timeSlotAissigments' => array(self::HAS_MANY, 'TimeSlotAissigment', 'timeSlot'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'timeslotName' => 'Timeslot Name',
			'startTime' => 'Start Time',
			'endTime' => 'End Time',
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
		$criteria->compare('timeslotName',$this->timeslotName,true);
		$criteria->compare('startTime',$this->startTime,true);
		$criteria->compare('endTime',$this->endTime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TimeSlot the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
