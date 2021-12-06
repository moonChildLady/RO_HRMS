<?php

/**
 * This is the model class for table "Approvers".
 *
 * The followings are the available columns in table 'Approvers':
 * @property integer $id
 * @property string $staffCode
 * @property string $approver
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property Staff $staffCode0
 * @property ContentTable $position0
 * @property Staff $approver0
 */
class Approvers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	//public $userId;
	public $Fullname;
	public $approverFullname;
	public $deleteApprover;
	
	public function tableName()
	{
		return 'Approvers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staffCode, approver, position, startDate', 'required'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('staffCode, approver, deleteApprover', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, approver, position, Fullname, approverFullname, startDate, endDate', 'safe', 'on'=>'search'),
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
			'position0' => array(self::BELONGS_TO, 'ContentTable', 'position'),
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
			'staffCode' => 'Staff Code',
			'approver' => 'Approver',
			'position' => 'Position',
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
		$sort = new CSort();
		$criteria->with = array("staffCode0", "approver0");
		$criteria->compare('id',$this->id);
		$criteria->compare('t.staffCode',$this->staffCode,true);
		$criteria->compare('approver',$this->approver,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('concat(staffCode0.surName, " ",staffCode0.givenName)',$this->Fullname,true);
		$criteria->compare('concat(approver0.surName, " ",approver0.givenName)',$this->approverFullname,true);
		$sort->defaultOrder= array(
			'staffCode'=>CSort::SORT_ASC,
			'position'=>CSort::SORT_ASC,
			//'id'=>CSort::SORT_ASC,
			
            
        );
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>array(
                        'pageSize'=>50,
                ),
		));
	}
	
	/*
public function getuserId(){
		return $this->approver0->id;
	}
*/

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Approvers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
