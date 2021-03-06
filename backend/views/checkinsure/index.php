<?php
use backend\models\Carbrand;
use backend\models\Caryear;
use backend\models\Carinfo;
use backend\models\Car;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\Packagedetail;
use backend\models\Packagecondition;
use backend\models\Product;
use toxor88\switchery\Switchery;
use yii2mod\alert\Alert;

$this->title = "เช็คเบี้ยประกัน";
//$this->css = "<i class='fa-pencil-square-o'></i>";
$prod = Product::find()->where(['status'=> 1])->all();
$search = '';
if(isset($searchtype)){
   $search = $searchtype;
 }else{
  $search = 0;
 }


// echo \yii2mod\alert\Alert::widget([
//     'useSessionFlash' => false,
//     'options' => [
//         'timer' => null,
//         'type' => \yii2mod\alert\Alert::TYPE_INPUT,
//         'title' => 'An input!',
//         'text' => "Write something interesting",
//         'confirmButtonText' => "Yes, delete it!",
//         'closeOnConfirm' => false,
//         'showCancelButton' => true,
//         'animation' => "slide-from-top",
//         'inputPlaceholder' => "Write something"
//     ],
//     'callback' => new \yii\web\JsExpression(' function(inputValue) { 
//                 if (inputValue === false) return false;      
//                 if (inputValue === "") { 
//                     swal.showInputError("You need to write something!");     
//                     return false;   
//                 }      
//                 swal("Nice!", "You wrote: " + inputValue, "success"); 
//     }')
// ]);


?>
<?php $form = ActiveForm::begin(); ?>
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken; ?>">
    <input type="hidden" id="search_type" name="search_type" value="<?=$search?>" />

<div class="row">
	<div class="col-lg-12">

        <div class="nav-tabs-custom">
            <ul id="search_tab" class="nav nav-tabs">
              <li id="tab_car_year" class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-car text-danger"></i> เช็คเบี้ยตามยี่ห้อรุ่นปีรถ</a></li>
              <li id="tab_car_code"><a href="#tab_2" data-toggle="tab"><i class="fa fa-check-square-o text-success"></i> เช็คเบี้ยตามรหัสรถ</a></li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                             <label class="control-label col-sm-3" for="name" style="bottom: -5px;text-align: right;">ผลิตภัณฑ์</label>
                             <div class="col-sm-5">
                                <?php if(isset($product)){$model->product = $product;}?>
                             <?= $form->field($model,'product')->widget(Select2::className(),[
                                'data'=>ArrayHelper::map($prod,'id',function($data){
                                    return $data->product_code." ".$data->name;
                                }),
                                'options'=>['placeholder'=>'เลือกผลิตภัณฑ์',
                                ],
                                 'pluginOptions'=>[
                                    'allowClear'=> true,
                                ]
                                ])->label(false) ?>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                             <label class="control-label col-sm-3" for="name" style="bottom: -5px;text-align: right;">ยี่ห้อ</label>
                             <div class="col-sm-5">
                                <?php if(isset($brand)){$model->brand = $brand;}?>
                             <?= $form->field($model,'brand')->widget(Select2::className(),[
                                'data'=>ArrayHelper::map(Carbrand::find()->all(),'id','name'),
                                'options'=>['placeholder'=>'เลือกยี่ห้อ','id'=>'brand',
                                    'onchange'=>'
                                        $.post("index.php?r=insurance/showmodel&id=' . '"+$(this).val(),function(data){
                                              $("select#car_model").html(data);
                                              $("select#car_model").prop("disabled","");
                                        });
                                    '
                                ],
                                 'pluginOptions'=>[
                                    'allowClear'=> true,
                                ]
                                ])->label(false) ?>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                             <label class="control-label col-sm-3" for="name" style="bottom: -5px;text-align: right;">รุ่น</label>
                             <div class="col-sm-5">
                             <?= $form->field($model,'model')->widget(Select2::className(),[
                                'data'=>ArrayHelper::map(Carinfo::find()->all(),'id','model'),
                                'options'=>['placeholder'=>'เลือกรุ่น','disabled'=>'disabled','id'=>'car_model'],
                                 'pluginOptions'=>[
                                    'allowClear'=> true,
                                ]
                                ])->label(false) ?>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                             <label class="control-label col-sm-3" for="name" style="bottom: -5px;text-align: right;">ปีรถ</label>
                             <div class="col-sm-5">
                                <?php if(isset($year)){$model->year = $year;}?>
                             <?= $form->field($model,'year')->widget(Select2::className(),[
                                'data'=>ArrayHelper::map(Caryear::find()->all(),'id','year_eng'),
                                'options'=>['placeholder'=>'เลือกปีรถ'],
                                 'pluginOptions'=>[
                                    'allowClear'=> true,
                                ]
                                ])->label(false) ?>
                             </div>
                        </div>
                    </div>
                </div><br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                             <label class="control-label col-sm-3" for="name" style="bottom: -5px;text-align: right;">รวม พรบ.</label>
                             <div class="col-sm-5">
                               <?php echo $form->field($model, 'include_act')->widget(Switchery::className(),['options'=>['label'=>'']])->label(false) ?>
                             </div>
                        </div>
                    </div>
                </div><br />
                
              </div>
               <div class="tab-pane" id="tab_2">
                  <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                             <label class="control-label col-sm-3" for="name" style="bottom: -5px;text-align: right;">ประเภทการใช้งานรถ</label>
                             <div class="col-sm-5">
                                <?= $form->field($model, 'usetype')->widget(Select2::className(),[
                                      'data'=> ArrayHelper::map(\backend\models\Act::find()->where(['status'=>1])->all(),'id','car_description'),
                                      'options'=>['placeholder'=>'เลือกประเภทรถ','id'=>'type_id',
                                          'onchange'=>'
                                            $.post("index.php?r=car/showact&id=' . '"+$(this).val(),function(data){
                                              $("select#carcode").html(data);
                                              $("select#carcode").prop("disabled","");
                                            });
                                          '
                                      ],
                                      'pluginOptions'=>[
                                        'allowClear'=> true,
                                      ]
                                 ])->label(false) ?>
                             </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                         <div class="form-group">
                             <label class="control-label col-sm-3" for="name" style="bottom: -5px;text-align: right;">รหัสรถ</label>
                             <div class="col-sm-5">
                                <?php if(isset($year)){$model->year = $year;}?>
                                    <?= $form->field($model,'carcode')->widget(Select2::className(),[
                                    'data'=>ArrayHelper::map(Car::find()->all(),'id',function($data){
                                        return $data->car_code." ".$data->name;
                                    }),
                                    'options'=>['placeholder'=>'เลือกรหัสรถ','id'=>'carcode','disabled'=>'disabled'],
                                     'pluginOptions'=>[
                                        'allowClear'=> true,
                                    ]
                                ])->label(false) ?>
                             </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                             <label class="control-label col-sm-3" for="name" style="bottom: -5px;text-align: right;"></label>
                             <div class="col-sm-5">
                             <input type="submit" value="ค้นหา" name="search" class="btn btn-primary" />
                             <div class="btn btn-default btn-quotation"><i class="fa fa-print"></i> สร้างใบเสนอราคา</div>
                             </div>
                        </div>
                    </div>
                </div>
          </div>
      </div>


		
		
	</div>
</div>
<?php ActiveForm::end(); ?>
<div class="row result">
	<div class="col-lg-12">
	<?php if(count($modellist)>0):?>
	<?php for($i=0;$i<=count($modellist)-1;$i++):?>
	 <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title"><span><?php echo Html::img('@web/uploads/logo/'.$modellist[$i]['logo'],['style'=>'width: 10%;'])?></span> <?=$modellist[$i]['insure_name']?></h3>
            <div class="pull-right"><h5><b><span style="color: #FF9933;"><?=$modellist[$i]['alltotal']==''?0:number_format($modellist[$i]['alltotal'],0)?> </span>-</b></h5></div>
          </div>
          <div class="box-body">
            <div class="row">
            	<div class="col-lg-2">
            		<h5><u><?= Product::getProdcode($modellist[$i]['insure_type'])?></u></h5>
            	</div>
            	<div class="col-lg-5">
            		<h5><u>ความคุ้มครอง</u></h5>
            	</div>
            	<div class="col-lg-5">
            		<h5><u>เงื่อนไข</u></h5>
            	</div>
            </div>
            <div class="row">
            	<div class="col-lg-2">
            		<h5><u></u></h5>
            	</div>
            	<div class="col-lg-5">
            		<table class="table">
            			<?php 
            			    $modelprotect = Packagedetail::find()->where(['package_id'=>$modellist[$i]['id']])->all();
            			    $x = 0;
            			?>
            			<?php foreach ($modelprotect as $value):?>

            			<tr>
            				<td>
            					<?php $x+=1;echo $x.".";?>
            				</td>
            				<td>
            					<?php if($value->actprotect_id!='')echo $value->actprotect->name;?>
            				</td>
            				<td>
            					<?php echo $value->amount;?>
            				</td>
            			</tr>
            			<?php endforeach;?>
            		</table>
            	</div>
            	<div class="col-lg-5">
            		<table class="table">
            			<?php 
            			    $modelcondition = Packagecondition::find()->where(['package_id'=>$modellist[$i]['id']])->all();
            			    $x = 0;
            			   // echo count($modelprotect);
            			?>
            			<?php foreach ($modelcondition as $value):?>

            			<tr>
            				<td style="width: 5%;">
            					<?php $x+=1;echo $x.".";?>
            				</td>
            				<td>
            					<?php echo \backend\helpers\ConditionTitle::getTypeById($value->title_id);?>
            				</td>
            				<td>
            					<?php echo $value->condition_text;?>
            				</td>
            				
            			</tr>
            			<?php endforeach;?>
            		</table>
            	</div>
            </div>
          </div>
          <div class="box-footer with-border">
          	<div class="row">
          		<div class="col-lg-12">
          			<div id="<?=$modellist[$i]['id']?>" class="btn btn-warning btn-quote">
          			<i class="fa fa-edit"></i> <span id="quote_txt">เสนอราคา</span>
          			</div>
          		</div>
          	</div>
          </div>
          <!-- /.box-body -->
        </div>
	<?php endfor;?>
		<?php elseif(isset($brand)&&!empty($brand)):?>
            <div class="data-not-found" style="padding: 20px 20px 20px 20px">
            	<div class="alert-danger" style="padding: 20px 20px 20px 20px; text-align: center">
            		<p><h3><i class="fa fa-info-circle"></i> ไม่พบข็อมูล</h3></p>
            	</div>
            </div>
	  	<?php endif;?>
	</div>
</div>
<form id="show_quotation" class="show_quotation" action="index.php?r=checkinsure/genquotation" method="post">
    <input type="hidden" name="list" class="list" value="" />
</form>
<?php $this->registerJs('
	var quotelist = [];

	$(function(){

      var hasbrand = "'.$brand.'";
      if(hasbrand > 0){
        $("#brand").trigger("change");
      }

      if($("#search_type").val() == "0"){
        $("#tab_car_year").addClass("active");
        $("#tab_car_code").removeClass("active");
        $("#tab_1").addClass("active");
        $("#tab_2").removeClass("active");
       
      }else{
        $("#tab_car_code").addClass("active");
        $("#tab_car_year").removeClass("active");
        $("#tab_1").removeClass("active");
        $("#tab_2").addClass("active");

      }
      $("#tab_car_year").click(function(){
        $("#search_type").val(0);
         $(".result").hide();
      });
       $("#tab_car_code").click(function(){
        $("#search_type").val(1);
         $(".result").hide();
      });
        $(".btn-quotation").hide();
      		var x = "'.$carmodel.'";
        	if(x!=""){
        		$("#car_model").prop("disabled","");
        	}
      	});

    $(".btn-quote").on("click",function(){

    	// $(this).removeClass("btn-warning");
    	// $(this).addClass("btn-success");
        if(quotelist.length > 3){
            alert("เลือกรายการเกิน 3 รายการแล้ว");
        }
    	$(this).toggleClass("btn-warning btn-success");
    	if($(this).find("#quote_txt").text() ==  "เสนอราคา"){
    		$(this).find("#quote_txt").text("เลือกแล้ว");
    		quotelist.push($(this).attr("id"));
    	}else{
    		$(this).find("#quote_txt").text("เสนอราคา");
    		quotelist.splice(quotelist.indexOf($(this).attr("id")),1);
    	}
    	if(quotelist.length > 0){
            $(".btn-quotation").show();
        }else{
            $(".btn-quotation").hide();
        }
       // alert(quotelist.length);
    });
    
    $(".btn-quotation").click(function(){
        if(quotelist.length <= 0){return;}
        var Url = "'.Yii::$app->getUrlManager()->createUrl("checkinsure/genquotation").'";
        $(".list").val(quotelist);
        $("form#show_quotation").submit();
    });
	
',static::POS_END);?>