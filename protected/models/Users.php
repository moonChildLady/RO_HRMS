<?php

/**
 * This is the model class for table "Users".
 *
 * The followings are the available columns in table 'Users':
 * @property integer $id
 * @property string $staffCode
 * @property string $password
 * @property string $resigned
 *
 * The followings are the available model relations:
 * @property Staff $staffCode0
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	
	public $FullnamewithStaffCode;
	public $Fullname;
	public $username;
	public $old_password;
	public $new_password;
	public $repeat_password;
	
	
	public function tableName()
	{
		return 'Users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staffCode, password', 'required', 'on'=>'create'),
			array('old_password, new_password, repeat_password', 'required', 'on' => 'changepassword'),
			array('old_password', 'findPasswords', 'on' => 'changepassword'),
			array('repeat_password', 'compare', 'compareAttribute'=>'new_password', 'on'=>'changepassword'),
			//array('new_password, repeat_password', 'required', 'on' => 'adminchangepassword'),
			array('repeat_password', 'compare', 'compareAttribute'=>'new_password', 'on'=>'adminchangepassword'),
			array('staffCode, password', 'length', 'max'=>100),
			array('resigned', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, password, resigned,username, Fullname', 'safe', 'on'=>'search'),
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
			'staffCodeEmploy' => array(self::BELONGS_TO, 'StaffEmployment', 'staffCode'),
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
			'password' => 'Password',
			'resigned' => 'Resigned',
			'old_password' => 'Old Password',
			'new_password' => 'New Password',
			'repeat_password' => 'Confirm Password',
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
		$criteria->with = array("staffCode0");
		$criteria->compare('id',$this->id);
		$criteria->compare('t.staffCode',$this->staffCode,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('resigned',$this->resigned,true);
		$criteria->compare('concat(staffCode0.surName, " ",staffCode0.givenName)',$this->Fullname,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFullnamewithStaffCode(){
		return $this->staffCode0->surName;
	}
	
	public function getusername(){
		return $this->staffCode0->surName;
	}
	
	public function findPasswords($attribute, $params)
    {
        $user = Users::model()->findByPk(Yii::app()->user->id);
        if ($user->password != md5($this->old_password))
            $this->addError($attribute, 'Old password is incorrect.');
    }
}
