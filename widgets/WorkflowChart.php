<?php
/**
 * Author: dungang
 * Date: 2017/6/21
 * Time: 9:23
 */

namespace dungang\activity\workflow\widgets;


use dungang\activity\workflow\models\Arc;
use dungang\activity\workflow\models\Place;
use dungang\activity\workflow\models\Transition;
use dungang\vis\VisAsset;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\helpers\Json;

class WorkflowChart extends Widget
{
    /**
     * @var string
     */
    public $placeColor='#2488dd';
    /**
     * @var Place[]
     */
    public $places;

    /**
     * @var string
     */
    public $transitionColor='green';

    /**
     * @var Transition[]
     */
    public $transitions;

    /**
     * @var string
     */
    public $arcColor='red';

    /**
     * @var Arc[]
     */
    public $arcs;

    public $nodes = [];
    public $edges = [];
    public $visOptions=[
        'layout'=>[
            'randomSeed'=>1,
            'improvedLayout'=>true,
        ]
    ];
    public $options = [
        'style'=>'height:500px;width:100%;'
    ];

    public function run()
    {
        VisAsset::register($this->getView());
        $this->options['id'] = $id = $this->getId();
        /* @var $places Place[] */
        $places = array_map(function( Place $place){
            $node =  [
                'id'=>'p'.$place->id,
                'label'=>$place->placeName,
                'color'=>$this->placeColor,
                'shape'=>'circle',
                'level'=>1,
                'title'=>$place->intro,
                'margin'=>10,
                'font'=>['color'=>'white','size'=>18]
            ];
            switch ($place->placeType) {
                case 'START':
                    $node['level'] = 1;
                    $node['color'] = [
                        'border'=>$this->placeColor,
                        'background'=>'white'
                    ];
                    $node['font']['color'] = $this->placeColor;
                    break;
                case 'END':
                    $node['color']='black';
                    $node['level'] = 9;
                    break;
                default:
                    $node['level'] = 5;
            }
            return $node;

        },$this->places);

        $transitions =  array_map(function( Transition $transition){
            return [
                'id'=>'t'.$transition->id,
                'label'=>$transition->transitName,
                'color'=>$this->transitionColor,
                'size'=> 40,
                'shape'=>'box',
                'title'=>$transition->intro,
                'margin'=>16,
                'font'=>['color'=>'white']
            ];
        },$this->transitions);
        $edges = array_map(function( Arc $arc){

            if ($arc->direction == 'IN') {
                return [
                    'arrows'=>'to',
                    'from'=>'p'.$arc->placeId,
                    'to' => 't'.$arc->transitionId,
                    'color'=>$this->arcColor,
                    'font'=>['size'=>6],
                    'label'=>$arc->conditionIntro?$arc->conditionIntro:'',
                ];
            } else {
                return [
                    'arrows'=>'to',
                    'from' => 't'.$arc->transitionId,
                    'to'=>'p'.$arc->placeId,
                    'color'=>$this->arcColor,
                    'font'=>['size'=>6],
                    'label'=>$arc->conditionIntro?$arc->conditionIntro:'',
                ];
            }
        },$this->arcs);
        $data = Json::encode([
            'nodes'=>array_merge($places, $transitions),
            'edges'=>$edges,
        ]);
        $visOptions = $this->visOptions?Json::encode($this->visOptions):'{}';
        $jsCode = "new vis.Network(document.getElementById('$id'),$data,$visOptions);";
        $this->view->registerJs($jsCode);
        return Html::tag('div','',$this->options);
    }
}