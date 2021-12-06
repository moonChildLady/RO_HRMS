<?php

/**
 * This is the model class for table "Department".
 *
 * The followings are the available columns in table 'Department':
 * @property integer $id
 * @property string $staffCode
 * @property integer $departmentID
 * @property integer $divisionID
 */
class Department extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Department';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staffCode', 'required'),
			//array('departmentID, divisionID', 'numerical', 'integerOnly'=>true),
			array('staffCode', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, departmentID, divisionID, companyID', 'safe', 'on'=>'search'),
			array('id, staffCode, departmentID, divisionID, companyID', 'safe'),
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
			/* 'staffCode0' => array(self::BELONGS_TO, 'Staff', '', 'foreignKey' => array(
				'staffCode'=>'staffCode'
			),
			'department0' => array(self::BELONGS_TO, 'ContentTable', '', 'foreignKey' => array(
				'departmentID'=>'id'
			),
			'division0' => array(self::BELONGS_TO, 'ContentTable', '', 'foreignKey' => array(
				'divisionID'=>'id'
			), */
			'department0' => array(self::BELONGS_TO, 'ContentTable', 'departmentID'),
			'division0' => array(self::BELONGS_TO, 'ContentTable', 'divisionID'),
			'company0' => array(self::BELONGS_TO, 'ContentTable', 'companyID'),
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
			'departmentID' => 'Department',
			'divisionID' => 'Division',
			'companyID' => 'Company',
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
		$criteria->compare('departmentID',$this->departmentID);
		$criteria->compare('divisionID',$this->divisionID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Department the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
