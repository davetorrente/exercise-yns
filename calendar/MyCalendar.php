<?php


class MyCalendar
{
    private $daysOfWeek = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");

    private $currentYear=0;

    private $currentMonth=0;

    private $currentDay=0;

    private $currentDate=null;

    private $daysInMonth=0;

    private $naviHref= null;

    public function __construct($naviHref){
        $this->naviHref = $naviHref;
    }

    /**
     * show the calendar
     */
    public function show() {
        $year = null;
        $month = null;
        if($year==null&&isset($_GET['year'])){

            $year = $_GET['year'];

        }else if($year == null){

            $year = date("Y",time());

        }

        if($month == null&&isset($_GET['month'])){

            $month = $_GET['month'];

        }else if($month==null){

            $month = date("m",time());

        }
        /**
         * saving the $year and $month to currentYear
         * and currentMonth property
         */
        $this->currentYear=$year;
        $this->currentMonth=$month;


        $this->daysInMonth=$this->_daysInMonth($month,$year);
        /**
         * HTML CONTENT
         */
        $content='<div id="calendar">'.
            '<div class="box">'.
            $this->_createNavi().
            '</div>'.
            '<div class="box-content">'.
            '<ul class="label">'.$this->_createLabels().'</ul>';
        $content.='<div class="clear"></div>';
        $content.='<ul class="dates">';
        $weeksInMonth = $this->_weeksInMonth($month,$year);
        // Create weeks in a month
        for( $i=0; $i<$weeksInMonth; $i++ ){

            //Create days in a week
            for($j=1;$j<=7;$j++){
                $content.=$this->_showDay($i*7+$j);
            }
        }

        $content.='</ul>';

        $content.='<div class="clear"></div>';

        $content.='</div>';

        $content.='</div>';
        return $content;
    }


    /**
     * create the li element for ul
     * comparing $cellNumber int param to the first day of the week
     */
    private function _showDay($cellNumber){
        //checking the pass parameter then compare it to the first day in the week
        if($this->currentDay==0){
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));

            if(intval($cellNumber) == intval($firstDayOfTheWeek)){

                $this->currentDay=1;

            }
        }
        //if it is not the first day, get the currentDate then assign the current Day in cellContent variable
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
            //formatting and getting the currentDate pass
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));

            $cellContent = $this->currentDay;
            $this->currentDay++;

        }else{

            $this->currentDate =null;

            $cellContent=null;
        }
        /**
         * RETURN HTML CHECK EVERY COLUMN IF REMAINDER 1 OR FIRST COLUMN IT WILL HAVE START CLASS
         * ELSE IF END COLUMN OR NO REMAINDER IT WILL HAVE END CLASS
         */
        return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
            ($cellContent==null?'mask':'').'">'.$cellContent.'</li>';
    }

    /**
     * create navigation button for previous and next
     */
    private function _createNavi(){

        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;

        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;

        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;

        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;

        return
            '<div class="header">'.
            '<a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
            '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
            '<a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '</div>';
    }

    /**
     * create li calendar week label
     */
    private function _createLabels(){

        $content='';

        foreach($this->daysOfWeek as $index=>$label){

            $content.='<li class="'.($index==6?'end title':'start title').' title">'.$label.'</li>';

        }

        return $content;
    }



    /**
     * calculate number of weeks in a particular month
     */
    private function _weeksInMonth($month=null,$year=null){

        if($year == null) {
            $year =  date("Y",time());
        }

        if($month == null) {
            $month = date("m",time());
        }

        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);

        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);

        //checking where the day ends
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
        //checking where the day starts
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));

        if($monthEndingDay<$monthStartDay){
            $numOfweeks++;
        }
        return $numOfweeks;
    }

    /**
     * calculate the number of days in a particular month
     */
    private function _daysInMonth($month=null,$year=null){
        if($year==null)
            $year =  date("Y",time());

        if($month==null)
            $month = date("m",time());

        return date('t',strtotime($year.'-'.$month.'-01'));
    }
}