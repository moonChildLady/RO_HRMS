<?php

/**
 * This is the model class for table "ApprovalLog".
 *
 * The followings are the available columns in table 'ApprovalLog':
 * @property integer $id
 * @property integer $leaveApplicationID
 * @property string $approver
 * @property string $status
 * @property string $createDate
 *
 * The followings are the available model relations:
 * @property LeaveApplication $leaveApplication
 * @property Staff $approver0
 */
class ApprovalLog extends CActiveRecord
{
	
	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ApprovalLog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('leaveApplicationID, approver, status', 'required', 'on'=>'create'),
			array('approval', 'required', 'on'=>'approval'),
			array('leaveApplicationID', 'numerical', 'integerOnly'=>true),
			array('approver', 'length', 'max'=>100),
			array('status', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, leaveApplicationID, approver, status, createDate', 'safe', 'on'=>'search'),
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
			'leaveApplication' => array(self::BELONGS_TO, 'LeaveApplication', 'leaveApplicationID'),
			'approver0' => array(self::BELONGS_TO, 'Staff', 'approver'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'leaveApplicationID' => 'Leave Application',
			'approver' => 'Approver',
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
		$criteria->compare('leaveApplicationID',$this->leaveApplicationID);
		$criteria->compare('approver',$this->approver,true);
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
	 * @return ApprovalLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
