<?php

/**
 * This is the model class for table "AttendanceRemarks".
 *
 * The followings are the available columns in table 'AttendanceRemarks':
 * @property integer $id
 * @property string $staffCode
 * @property string $timeRecord
 * @property string $createdBy
 * @property string $createDate
 *
 * The followings are the available model relations:
 * @property Staff $createdBy0
 * @property Staff $staffCode0
 */
class AttendanceRemarks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'AttendanceRemarks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staffCode, timeRecord, createdBy', 'required'),
			array('staffCode, createdBy, createDate, remark', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, timeRecord, createdBy, createDate, remark', 'safe', 'on'=>'search'),
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
			'createdBy0' => array(self::BELONGS_TO, 'Staff', 'createdBy'),
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
			'timeRecord' => 'Time Record',
			'createdBy' => 'Created By',
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
		$criteria->compare('timeRecord',$this->timeRecord,true);
		$criteria->compare('createdBy',$this->createdBy,true);
		$criteria->compare('createDate',$this->createDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AttendanceRemarks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
