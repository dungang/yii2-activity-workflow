<?php

use yii\db\Migration;

/**
 * Handles the creation of table `workflow`.
 */
class m170118_095547_create_workflow_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->createTable('wf_task',[
            'id'=>$this->primaryKey()->unsigned(),
            'taskName'=>$this->string(128)->notNull(),
            'handler'=>$this->string(64)->notNull(),
            'params'=>$this->string(64)->notNull()->defaultValue(''),
            'intro'=>$this->string(255)->notNull()->defaultValue(''),
            'createdAt'=>$this->dateTime()->comment('The date and time on which this record was created.'),
            'createdUser'=>$this->integer()->comment('The identity of the user who created this record.'),
            'updatedAt'=>$this->dateTime()->comment('The date and time on which this record was last changed.'),
            'updatedUser'=>$this->integer()->comment('The identity of the user who last changed this record.'),
        ]);

        $this->createTable('wf_workflow', [
            'id' => $this->primaryKey()->unsigned(),
            'workflowName'=>$this->string(128)->notNull(),
            'document'=>$this->string(32)->notNull()->defaultValue(''),
            'startTask'=>$this->integer()->notNull()->defaultValue(0)->comment('Required. The identity of the application task which, when executed, creates a new workflow case and puts a token on the start place.'),
            'isValid enum("YES","NO","USED","ARCHIVED") default "NO" COMMENT "Default is NO. After defining all the places, transitions and arcs for a workflow process it must be validated before it can be used. This field shows the result of that validation."',
            'intro'=>$this->text(),
            'usedAt'=>$this->dateTime(),
            'archivedAt'=>$this->dateTime(),
            'createdAt'=>$this->dateTime()->comment('The date and time on which this record was created.'),
            'createdUser'=>$this->integer()->comment('The identity of the user who created this record.'),
            'updatedAt'=>$this->dateTime()->comment('The date and time on which this record was last changed.'),
            'updatedUser'=>$this->integer()->comment('The identity of the user who last changed this record.'),
        ]);

        $this->createTable('wf_place', [
            'id' => $this->primaryKey()->unsigned(),
            'workflowId'=> $this->integer()->notNull()->unsigned()->comment('Required. Points to an entry on the WORKFLOW table.'),
            'placeName'=>$this->string(64)->notNull(),
            'intro'=>$this->string(64)->comment('intro'),
            //Required. Valid options are:
            //1 = start place (there can be only one).
            //5 = intermediate place (there can be any number).
            //9 = end place (there can be only one).
            //'placeType'=>$this->smallInteger(4)->defaultValue(1)->comment('When a new workflow process is created a start place and an end place will be created automatically. The user is responsible for creating all the intermediate places.'),
            '`placeType` ENUM(\'START\', \'INTER\', \'END\') default "INTER" COMMENT "When a new workflow process is created a start place and an end place will be created automatically. The user is responsible for creating all the intermediate places."',
            'createdAt'=>$this->dateTime()->comment('The date and time on which this record was created.'),
            'createdUser'=>$this->integer()->comment('The identity of the user who created this record.'),
            'updatedAt'=>$this->dateTime()->comment('The date and time on which this record was last changed.'),
            'updatedUser'=>$this->integer()->comment('The identity of the user who last changed this record.'),
        ]);

        $this->createTable('wf_transition', [
            'id' => $this->primaryKey()->unsigned(),
            'workflowId'=> $this->integer()->notNull()->unsigned(),
            'taskId'=>$this->integer()->notNull()->unsigned()->defaultValue(0)->comment('Required. The identity of the application task which will be activated when this transition is fired.'),
            'role'=> $this->string(32)->comment('Required. The identity of the group of users (ROLE) to which this workitem will be assigned when the entry is created. If this is no-blank the corresponding workitem will be available to all users who share that role and not a single specified user.'),
            'transitName'=>$this->string(64)->notNull(),
            'triggerSource ENUM(\'AUTO\', \'USER\', \'MSG\', \'TIME\') DEFAULT \'USER\' COMMENT "A transition cannot be fired until there is at least one FREE token on each of its input places."',
            'timeLimit'=>$this->integer()->comment('Optional. Only valid if transition_trigger=TIME. It is a value in minutes, but is displayed and input in hours and minutes. Valid values are between 0:01 and 999:59.'),
            'intro'=>$this->text(),
            'createdAt'=>$this->dateTime()->comment('The date and time on which this record was created.'),
            'createdUser'=>$this->integer()->comment('The identity of the user who created this record.'),
            'updatedAt'=>$this->dateTime()->comment('The date and time on which this record was last changed.'),
            'updatedUser'=>$this->integer()->comment('The identity of the user who last changed this record.'),
        ]);

        $this->createTable('wf_arc', [
            'workflowId' => $this->integer()->notNull(),
            'placeId' => $this->integer()->notNull(),
            'transitionId' => $this->integer()->notNull(),
            'direction enum("IN","OUT") default "IN"',
            '`arcType` ENUM(\'SEQUENCE\', \'EXPLICIT_OR_SPLIT\', \'IMPLICIT_OR_SPLIT\', \'OR_JOIN\', \'AND_SPLIT\', \'AND_JOIN\') DEFAULT \'SEQUENCE\'',
            'conditionExpress'=>$this->string(255)->comment('guard'),
            'conditionIntro'=>$this->string(64)->notNull()->defaultValue(''),
            'createdAt'=>$this->dateTime()->comment('The date and time on which this record was created.'),
            'createdUser'=>$this->integer()->comment('The identity of the user who created this record.'),
            'updatedAt'=>$this->dateTime()->comment('The date and time on which this record was last changed.'),
            'updatedUser'=>$this->integer()->comment('The identity of the user who last changed this record.'),
            'PRIMARY KEY (workflowId, placeId, transitionId)',
        ]);

        $this->createTable('wf_process', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'workflowId'=> $this->integer()->notNull()->unsigned()->defaultValue(0),
            'context'=>$this->string(255)->notNull()->comment('The primary key of the database entry to which this case refers in the format of an sql WHERE clause.This is produced by the application task identified in START_TASK_ID on the WORKFLOW table.'),
            '`processStatus` ENUM(\'OPEN\', \'CLOSED\', \'SUSPENDED\', \'CANCELLED\') DEFAULT \'OPEN\'',
            'startedAt'=>$this->dateTime()->comment('Set by the system when this entry is opened.'),
            'endedAt'=>$this->dateTime()->comment('Set by the system when this entry is closed. This occurs when a token is placed in the end place.'),
            'createdAt'=>$this->dateTime()->comment('The date and time on which this record was created.'),
            'createdUser'=>$this->integer()->comment('The identity of the user who created this record.'),
            'updatedAt'=>$this->dateTime()->comment('The date and time on which this record was last changed.'),
            'updatedUser'=>$this->integer()->comment('The identity of the user who last changed this record.'),
        ]);

        $this->createTable('wf_token', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'workflowId'=> $this->integer()->notNull()->unsigned(),
            'placeId'=> $this->integer()->notNull()->unsigned(),
            'processId'=> $this->integer()->notNull()->unsigned(),
            'context'=>$this->string(255)->notNull()->comment('The primary key of the database entry as passed down by the previous transition (application task).'),
            '`tokenStatus` ENUM(\'FREE\', \'LOCKED\', \'CONSUMED\', \'CANCELLED\') DEFAULT \'FREE\' COMMENT "When a token is created it will automatically have a FREE status. A token on an input place must be FREE before a transition can be fired."',
            'enabledAt'=>$this->dateTime()->comment('The date and time on which this token appeared in this place.'),
            'cancelledAt'=>$this->dateTime()->comment('The date and time on which this token was cancelled.'),
            'consumedAt'=>$this->dateTime()->comment('The date and time on which this token was consumed by a transition being fired.'),
        ]);

        $this->createTable('wf_work_item', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'workflowId'=> $this->integer()->notNull()->unsigned(),
            'transitionId'=> $this->integer()->notNull()->unsigned(),
            'processId'=> $this->integer()->notNull()->unsigned(),
            'taskId'=>$this->integer()->notNull()->unsigned()->defaultValue(0)->comment('Required. The identity of the application task which will be activated when this transition is fired.'),
            'context'=>$this->string(255)->comment('The primary key of a database entry that will be passed to the application task when this workitem is processed.'),
            'triggerSource ENUM(\'AUTO\', \'USER\', \'MSG\', \'TIME\')  COMMENT "Set by the system. Shows how this transition was fired."',
            '`workStatus` ENUM(\'ENABLED\', \'IN_PROGRESS\', \'CANCELLED\', \'FINISHED\') DEFAULT \'ENABLED\'',
            'enabledAt'=>$this->dateTime()->comment('The data and time on which this workitem was enabled.'),
            'deadlinedAt'=>$this->dateTime()->comment('where the transition_trigger=TIME this is the date and time on which the deadline expires.'),
            'finishedAt'=>$this->dateTime()->comment('The data and time on which this workitem was finished'),
            'cancelledAt'=>$this->dateTime()->comment('The data and time on which this workitem was cancelled'),
            'user'=> $this->integer()->notNull()->unsigned(),
            'role'=> $this->string(32)->notNull(),
        ]);

        $this->createTable('wf_document', [
            'id' => $this->primaryKey()->unsigned(),
            'document'=>$this->string(32)->notNull()->unique(),
            'workflowId'=> $this->integer()->defaultValue(0)->unsigned(),
            'name'=>$this->string(128)->notNull(),
            'docModel'=>$this->string(128),
            'intro'=>$this->text(),
            'createdAt'=>$this->dateTime()->comment('The date and time on which this record was created.'),
            'createdUser'=>$this->integer()->comment('The identity of the user who created this record.'),
            'updatedAt'=>$this->dateTime()->comment('The date and time on which this record was last changed.'),
            'updatedUser'=>$this->integer()->comment('The identity of the user who last changed this record.'),
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('wf_document');
        $this->dropTable('wf_workflow');
        $this->dropTable('wf_place');
        $this->dropTable('wf_transition');
        $this->dropTable('wf_arc');
        $this->dropTable('wf_process');
        $this->dropTable('wf_token');
        $this->dropTable('wf_work_item');
    }
}
