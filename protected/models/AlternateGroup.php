<?php

/**
 * This is the model class for table "alternateGroup".
 *
 * The followings are the available columns in table 'alternateGroup':
 * @property integer $id
 * @property string $staffCode
 * @property string $groupID
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Staff $staffCode0
 */
class AlternateGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	 
	public $Fullname;
	public function tableName()
	{
		return 'alternateGroup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staffCode, groupID', 'required'),
			array('staffCode', 'length', 'max'=>100),
			array('groupID', 'length', 'max'=>10),
			array('status', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, groupID, status', 'safe', 'on'=>'search'),
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
			'GroupName0' => array(self::BELONGS_TO, 'ContentTable', 'groupID'),
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
			'groupID' => 'Group',
			'status' => 'Status',
			'alternateGroupID'=>'Alternate Group'
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
		$criteria->compare('groupID',$this->groupID,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AlternateGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getalternateGroupName(){
	
	
		$str = "";	
		if($this->alternateGroupID=="0"){
			$str = "Every Saturday";
		}
		
		if($this->alternateGroupID=="1"){
			$str = "Group 1";
		}
		
		if($this->alternateGroupID=="2"){
			$str = "Group 2";
		}
		
		if($this->alternateGroupID=="3"){
			$str = "Group 3";
		}
		if($this->alternateGroupID=="4"){
			$str = "Group 4";
		}
		if($this->alternateGroupID=="99"){
			$str = "No Alternate";
		}
		
		return $str;
	}
}
