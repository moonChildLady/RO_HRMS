<?php

/**
 * This is the model class for table "Projects".
 *
 * The followings are the available columns in table 'Projects':
 * @property integer $id
 * @property string $year
 * @property string $code
 * @property string $code2
 * @property string $projectTitle
 */
class Projects extends CActiveRecord
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
			array('year, code, projectTitle', 'required'),
			array('year', 'length', 'max'=>4),
			array('code, code2, startDate, endDate', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, year, code, code2, projectTitle, startDate, endDate', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'year' => 'Year',
			'code' => 'Code',
			'code2' => 'Code2',
			'projectTitle' => 'Project Title',
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
		$criteria->compare('id',$this->id);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('code2',$this->code2,true);
		$criteria->compare('projectTitle',$this->projectTitle,true);
		
		$sort->defaultOrder= array(
			'id'=>CSort::SORT_DESC,
			
            
        );
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Projects the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
