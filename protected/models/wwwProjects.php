<?php

/**
 * This is the model class for table "Projects".
 *
 * The followings are the available columns in table 'Projects':
 * @property integer $id
 * @property string $title
 * @property string $projectName
 * @property string $location
 * @property string $nature
 * @property string $contractSum
 * @property string $clientName
 * @property string $architect
 * @property string $mainContrator
 * @property string $status
 * @property string $createDate
 *
 * The followings are the available model relations:
 * @property ProjectType[] $projectTypes
 * @property ProjectsImages[] $projectsImages
 */
class wwwProjects extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Projects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, projectName, status', 'required'),
			array('status', 'length', 'max'=>8),
			array('location, nature, contractSum, clientName, architect, mainContrator', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, projectName, location, nature, contractSum, clientName, architect, mainContrator, status, createDate', 'safe', 'on'=>'search'),
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
			'projectTypes' => array(self::HAS_MANY, 'ProjectType', 'projectID'),
			'projectsImages' => array(self::HAS_MANY, 'ProjectsImages', 'projectID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'projectName' => 'Project Name',
			'location' => 'Location',
			'nature' => 'Nature',
			'contractSum' => 'Contract Sum',
			'clientName' => 'Client Name',
			'architect' => 'Architect',
			'mainContrator' => 'Main Contrator',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('projectName',$this->projectName,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('nature',$this->nature,true);
		$criteria->compare('contractSum',$this->contractSum,true);
		$criteria->compare('clientName',$this->clientName,true);
		$criteria->compare('architect',$this->architect,true);
		$criteria->compare('mainContrator',$this->mainContrator,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('createDate',$this->createDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_www;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return wwwProjects the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
