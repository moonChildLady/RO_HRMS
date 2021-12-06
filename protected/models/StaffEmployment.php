<?php

/**
 * This is the model class for table "StaffEmployment".
 *
 * The followings are the available columns in table 'StaffEmployment':
 * @property integer $id
 * @property string $staffCode
 * @property string $startDate
 * @property string $endDate
 * @property integer $Basis
 * @property integer $positionID
 *
 * The followings are the available model relations:
 * @property Staff $staffCode0
 * @property ContentTable $basis
 * @property ContentTable $position
 */
class StaffEmployment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	 
	public $balance = 0;
	public $Fullname;
	public $chineseName;
	public $HKID;
	public $createPortalAccount;
	public $password;
	public $Alternate;
	public $Group;
	public $nickName;
	public $dob;
	public $mobile;
	public $CWR;
	public $CWRExpiryDate;
	public $WhiteCard;
	public $WhiteCardExpiryDate;
	public $greenCard;
	public $greenCardExpiryDate;
	public $department;
	public $division;
	public $company;
	
	public function tableName()
	{
		return 'StaffEmployment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('startDate, Basis', 'required'),
			array('Basis, positionID', 'numerical', 'integerOnly'=>true),
			array('staffCode', 'length', 'max'=>100),
			array('endDate, department, probationEndDate, projectCode, registeredTrade', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, startDate, endDate, Basis, positionID, Fullname, leaveGroup, balance, Alternate, nickName, Group, chineseName, HKID, mobile, CWR, whiteCard, department, division, company, probationEndDate, projectCode, registeredTrade', 'safe', 'on'=>'search'),
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
			'basis' => array(self::BELONGS_TO, 'ContentTable', 'Basis'),
			'position' => array(self::BELONGS_TO, 'ContentTable', 'positionID'),
			'leaveGroup' => array(self::BELONGS_TO, 'ContentTable', 'leaveGroup'),
			'balance0' => array(self::BELONGS_TO, 'LeaveBalance', 'staffCode'),
			'user' => array(self::BELONGS_TO, 'Users', 'staffCode'),
			//'department0' => array(self::BELONGS_TO, 'Department', 'staffCode'),
			'department0' => array(self::BELONGS_TO, 'Department', '', 'foreignKey' => array(
				'staffCode'=>'staffCode',
			)),
			
			//'division0' => array(self::BELONGS_TO, 'Department', 'staffCode'),
			
			//'AlternateGroup0' => array(self::BELONGS_TO, 'AlternateGroup', 'staffCode'),
			'AlternateGroup0' => array(self::BELONGS_TO, 'AlternateGroup', '', 'foreignKey' => array(
				'staffCode'=>'staffCode',
				//'currentYear'=>date('Y'),
			),
			'condition'=>'AlternateGroup0.currentYear='.date('Y')
			),
			//'AlternateGroup1' => array(self::BELONGS_TO, 'AlternateGroup', 'staffCode'),
			'AlternateGroup1' => array(self::BELONGS_TO, 'AlternateGroup', '', 'foreignKey' => array(
				'staffCode'=>'staffCode'
			),
			'condition'=>'AlternateGroup1.currentYear='.date('Y')
			),
			
			
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
			'startDate' => 'Start Date',
			'endDate' => 'End Date',
			'Basis' => 'Basis',
			'positionID' => 'Position',
			'Fullname' => 'Fullname',
			'leaveGroup' => 'leaveGroup',
			'balance' => 'balance',
			'nickName' => 'Preferred name',
			'probationEndDate' => 'Probation EndDate',
			'projectCode' => 'Project Code',
			'registeredTrade' => 'Registered Trade',
			'CWRExpiryDate' => 'CWR Expiry Date',
			'WhiteCardExpiryDate' => 'White Card ExpiryDate',
			'WhiteCard' => 'White Card',
			'greenCardExpiryDate' => 'Green Card ExpiryDate',
			'greenCard' => 'Green Card',
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
	public function search($param = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$sort = new CSort();
		$criteria->with = array("staffCode0", "position","AlternateGroup0","AlternateGroup1", "department0");
		$criteria->compare('id',$this->id);
		$criteria->compare('t.staffCode',$this->staffCode,true);
		$criteria->compare('startDate',$this->startDate,true);
		$criteria->compare('endDate',$this->endDate,true);
		$criteria->compare('Basis',$this->Basis);
		$criteria->compare('positionID',$this->positionID);
		$criteria->compare('leaveGroup',$this->leaveGroup);
		//$criteria->compare('leaveGroup',$this->leaveGroup);
		$criteria->compare('AlternateGroup0.groupID', $this->Group);
		$criteria->compare('projectCode', $this->projectCode);
		$criteria->compare('registeredTrade', $this->registeredTrade);
		$criteria->compare('AlternateGroup1.alternateGroupID', $this->Alternate);
		$criteria->compare('department0.departmentID', $this->department);
		$criteria->compare('department0.divisionID', $this->division);
		$criteria->compare('department0.companyID', $this->company);
		$criteria->compare('CONCAT(staffCode0.surName," ",staffCode0.givenName)',$this->Fullname,true);
		$criteria->compare('staffCode0.chineseName',$this->chineseName,true);
		$criteria->compare('staffCode0.HKID',$this->HKID,true);
		$criteria->compare('staffCode0.nickName',$this->nickName,true);
		$criteria->compare('staffCode0.mobilePhone', $this->mobile, true);
		//$criteria->compare('staffCode0.whiteCard', $this->whiteCard, true);
		$criteria->addNotInCondition('staffCode0.staffCode', array('999998','9999999', '9999998', '9999997'));
		$criteria->order = 'CAST(staffCode0.staffCode as decimal(38,10)) DESC';
		
		//CAST(`a` AS DECIMAL(10,2)) DESC
		$sort->defaultOrder= array(
			//'staffCode0.id'=>CSort::SORT_DESC,
			//'t.staffCode'=>CSort::SORT_ASC,
			//'position.content'=>CSort::SORT_ASC,
            
        );
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>array(
                        'pageSize'=>50,
                ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffEmployment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
