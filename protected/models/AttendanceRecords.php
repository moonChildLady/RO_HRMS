<?php

/**
 * This is the model class for table "AttendanceRecords".
 *
 * The followings are the available columns in table 'AttendanceRecords':
 * @property integer $id
 * @property string $staffCode
 * @property string $timeRecord
 * @property string $remarks
 */
class AttendanceRecords extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'AttendanceRecords';
	}
	
	public $uploadfiles;
	public $month;
	public $location;
	public $reportType;
	public $dateRecord;
	public $startDate = "2018-03-16";
	public $endDate= "2018-03-31";
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('staffCode, timeRecord', 'required'),
			//array('staffCode', 'length', 'max'=>100),
			array('dateRecord', 'safe'),
			array('uploadfiles', 'file', 'types'=>'xls,xlsx', 'maxSize'=>1024 * 1024 * 5, 'tooLarge'=>'File has to be smaller than 5MB', 'safe' => false, 'allowEmpty'=>false, 'on'=>'upload'),
			//array('deviceID', 'numerical', 'integerOnly'=>true),
			array('id, staffCode, timeRecord, remarks, uploadfiles, deviceID, type, place', 'safe', 'on'=>'create'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, timeRecord, remarks, uploadfiles, deviceID, type, place', 'safe', 'on'=>'search'),
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
			'StaffEmployment0' => array(self::BELONGS_TO, 'StaffEmployment', 'staffCode'),
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
			'remarks' => 'Remarks',
			'uploadfiles' => 'RAW Data',
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
		$criteria->compare('remarks',$this->remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AttendanceRecords the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
