<?php

use Illuminate\Database\Seeder;

class PatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bpmn_patterns')->insert([
            'title' => 'Peminjaman Barang',
            'category' => 'Perlengkapan',
            'description' => 'Permintaan peminjaman barang dalam pabrik oleh mekanik.',
            'bpmn' => '<?xml version="1.0" encoding="UTF-8"?>
<definitions xmlns="http://www.omg.org/spec/BPMN/20100524/MODEL" xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI" xmlns:omgdc="http://www.omg.org/spec/DD/20100524/DC" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:di="http://www.omg.org/spec/DD/20100524/DI" targetNamespace="" xsi:schemaLocation="http://www.omg.org/spec/BPMN/20100524/MODEL http://www.omg.org/spec/BPMN/2.0/20100501/BPMN20.xsd">
  <collaboration id="Collaboration_1j15i25">
    <participant id="Participant_1b82dzh" name="Perusahaan" processRef="Process_1jgu9qa" />
  </collaboration>
  <process id="Process_1jgu9qa">
    <laneSet id="LaneSet_0jigusz">
      <lane id="Lane_122ptis" name="Mekanik Lapangan">
        <flowNodeRef>Task_16v0wnj</flowNodeRef>
        <flowNodeRef>StartEvent_1y78bcg</flowNodeRef>
      </lane>
      <lane id="Lane_1u9fwyr" name="Administrasi">
        <flowNodeRef>ExclusiveGateway_1wkvjkm</flowNodeRef>
        <flowNodeRef>Task_0voor4t</flowNodeRef>
        <flowNodeRef>Task_1s3mqfn</flowNodeRef>
        <flowNodeRef>Task_098tdvm</flowNodeRef>
        <flowNodeRef>EndEvent_0zv54kr</flowNodeRef>
      </lane>
      <lane id="Lane_0880nsc" name="Manajer Teknis">
        <flowNodeRef>Task_0oygznn</flowNodeRef>
        <flowNodeRef>ExclusiveGateway_0srwnl5</flowNodeRef>
        <flowNodeRef>EndEvent_08nxsnb</flowNodeRef>
      </lane>
    </laneSet>
    <sequenceFlow id="SequenceFlow_1afh5q6" sourceRef="StartEvent_1y78bcg" targetRef="Task_16v0wnj" />
    <sequenceFlow id="SequenceFlow_0wg2dxn" sourceRef="Task_16v0wnj" targetRef="Task_1s3mqfn" />
    <sequenceFlow id="SequenceFlow_19ngtyn" sourceRef="Task_1s3mqfn" targetRef="Task_0voor4t" />
    <sequenceFlow id="SequenceFlow_0e1licx" sourceRef="Task_0voor4t" targetRef="ExclusiveGateway_1wkvjkm" />
    <sequenceFlow id="SequenceFlow_0pwv8dy" name="Tidak tersedia" sourceRef="ExclusiveGateway_1wkvjkm" targetRef="Task_1s3mqfn" />
    <task id="Task_16v0wnj" name="Membuat permintaan barang">
      <incoming>SequenceFlow_1afh5q6</incoming>
      <outgoing>SequenceFlow_0wg2dxn</outgoing>
    </task>
    <exclusiveGateway id="ExclusiveGateway_1wkvjkm">
      <incoming>SequenceFlow_0e1licx</incoming>
      <outgoing>SequenceFlow_0pwv8dy</outgoing>
      <outgoing>SequenceFlow_1crz0se</outgoing>
    </exclusiveGateway>
    <task id="Task_0voor4t" name="Mengecek ketersediaan">
      <incoming>SequenceFlow_19ngtyn</incoming>
      <outgoing>SequenceFlow_0e1licx</outgoing>
    </task>
    <task id="Task_1s3mqfn" name="Memilih barang">
      <incoming>SequenceFlow_0wg2dxn</incoming>
      <incoming>SequenceFlow_0pwv8dy</incoming>
      <outgoing>SequenceFlow_19ngtyn</outgoing>
    </task>
    <task id="Task_0oygznn" name="Memeriksa permintaan barang">
      <incoming>SequenceFlow_1crz0se</incoming>
      <outgoing>SequenceFlow_16xq3s0</outgoing>
    </task>
    <sequenceFlow id="SequenceFlow_1crz0se" name="Tersedia" sourceRef="ExclusiveGateway_1wkvjkm" targetRef="Task_0oygznn" />
    <exclusiveGateway id="ExclusiveGateway_0srwnl5">
      <incoming>SequenceFlow_16xq3s0</incoming>
      <outgoing>SequenceFlow_0cn0u9f</outgoing>
      <outgoing>SequenceFlow_0y8twcv</outgoing>
    </exclusiveGateway>
    <sequenceFlow id="SequenceFlow_16xq3s0" sourceRef="Task_0oygznn" targetRef="ExclusiveGateway_0srwnl5" />
    <sequenceFlow id="SequenceFlow_0cn0u9f" name="Diterima" sourceRef="ExclusiveGateway_0srwnl5" targetRef="Task_098tdvm" />
    <task id="Task_098tdvm" name="Membuat PO">
      <incoming>SequenceFlow_0cn0u9f</incoming>
      <outgoing>SequenceFlow_0yrmgpx</outgoing>
    </task>
    <sequenceFlow id="SequenceFlow_0y8twcv" name="Ditolak" sourceRef="ExclusiveGateway_0srwnl5" targetRef="EndEvent_08nxsnb" />
    <endEvent id="EndEvent_08nxsnb" name="Permintaan Ditolak">
      <incoming>SequenceFlow_0y8twcv</incoming>
    </endEvent>
    <endEvent id="EndEvent_0zv54kr" name="PO Dibuat">
      <incoming>SequenceFlow_0yrmgpx</incoming>
    </endEvent>
    <sequenceFlow id="SequenceFlow_0yrmgpx" sourceRef="Task_098tdvm" targetRef="EndEvent_0zv54kr" />
    <startEvent id="StartEvent_1y78bcg" name="Butuh Barang Baru">
      <outgoing>SequenceFlow_1afh5q6</outgoing>
    </startEvent>
  </process>
  <bpmndi:BPMNDiagram id="sid-74620812-92c4-44e5-949c-aa47393d3830">
    <bpmndi:BPMNPlane id="sid-cdcae759-2af7-4a6d-bd02-53f3352a731d" bpmnElement="Collaboration_1j15i25" stroke="#000" fill="#fff">
      <bpmndi:BPMNShape id="Participant_1b82dzh_di" bpmnElement="Participant_1b82dzh" isHorizontal="true">
        <omgdc:Bounds x="147" y="149" width="898" height="451" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="Lane_122ptis_di" bpmnElement="Lane_122ptis" isHorizontal="true">
        <omgdc:Bounds x="177" y="149" width="868" height="145" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="Lane_1u9fwyr_di" bpmnElement="Lane_1u9fwyr" isHorizontal="true">
        <omgdc:Bounds x="177" y="294" width="868" height="140" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="Lane_0880nsc_di" bpmnElement="Lane_0880nsc" isHorizontal="true">
        <omgdc:Bounds x="177" y="434" width="868" height="166" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="StartEvent_1y78bcg_di" bpmnElement="StartEvent_1y78bcg">
        <omgdc:Bounds x="224" y="197" width="36" height="36" />
        <bpmndi:BPMNLabel>
          <omgdc:Bounds x="208" y="240" width="68" height="27" />
        </bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="Task_16v0wnj_di" bpmnElement="Task_16v0wnj">
        <omgdc:Bounds x="307" y="175" width="100" height="80" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNEdge id="SequenceFlow_1afh5q6_di" bpmnElement="SequenceFlow_1afh5q6">
        <di:waypoint x="260" y="215" />
        <di:waypoint x="307" y="215" />
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNShape id="Task_1s3mqfn_di" bpmnElement="Task_1s3mqfn">
        <omgdc:Bounds x="307" y="330" width="100" height="80" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNEdge id="SequenceFlow_0wg2dxn_di" bpmnElement="SequenceFlow_0wg2dxn">
        <di:waypoint x="357" y="255" />
        <di:waypoint x="357" y="330" />
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNShape id="Task_0voor4t_di" bpmnElement="Task_0voor4t">
        <omgdc:Bounds x="466" y="330" width="100" height="80" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNEdge id="SequenceFlow_19ngtyn_di" bpmnElement="SequenceFlow_19ngtyn">
        <di:waypoint x="407" y="370" />
        <di:waypoint x="466" y="370" />
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNShape id="ExclusiveGateway_1wkvjkm_di" bpmnElement="ExclusiveGateway_1wkvjkm" isMarkerVisible="true">
        <omgdc:Bounds x="620" y="345" width="50" height="50" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNEdge id="SequenceFlow_0e1licx_di" bpmnElement="SequenceFlow_0e1licx">
        <di:waypoint x="566" y="370" />
        <di:waypoint x="620" y="370" />
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="SequenceFlow_0pwv8dy_di" bpmnElement="SequenceFlow_0pwv8dy">
        <di:waypoint x="645" y="345" />
        <di:waypoint x="645" y="302" />
        <di:waypoint x="391" y="302" />
        <di:waypoint x="391" y="330" />
        <bpmndi:BPMNLabel>
          <omgdc:Bounds x="495" y="306" width="69" height="14" />
        </bpmndi:BPMNLabel>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNShape id="Task_0oygznn_di" bpmnElement="Task_0oygznn">
        <omgdc:Bounds x="595" y="484" width="100" height="80" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNEdge id="SequenceFlow_1crz0se_di" bpmnElement="SequenceFlow_1crz0se">
        <di:waypoint x="645" y="395" />
        <di:waypoint x="645" y="484" />
        <bpmndi:BPMNLabel>
          <omgdc:Bounds x="649" y="408" width="42" height="14" />
        </bpmndi:BPMNLabel>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNShape id="ExclusiveGateway_0srwnl5_di" bpmnElement="ExclusiveGateway_0srwnl5" isMarkerVisible="true">
        <omgdc:Bounds x="745" y="499" width="50" height="50" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNEdge id="SequenceFlow_16xq3s0_di" bpmnElement="SequenceFlow_16xq3s0">
        <di:waypoint x="695" y="524" />
        <di:waypoint x="745" y="524" />
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNShape id="Task_098tdvm_di" bpmnElement="Task_098tdvm">
        <omgdc:Bounds x="720" y="330" width="100" height="80" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNEdge id="SequenceFlow_0cn0u9f_di" bpmnElement="SequenceFlow_0cn0u9f">
        <di:waypoint x="770" y="499" />
        <di:waypoint x="770" y="410" />
        <bpmndi:BPMNLabel>
          <omgdc:Bounds x="776" y="452" width="41" height="14" />
        </bpmndi:BPMNLabel>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNShape id="EndEvent_08nxsnb_di" bpmnElement="EndEvent_08nxsnb">
        <omgdc:Bounds x="902" y="506" width="36" height="36" />
        <bpmndi:BPMNLabel>
          <omgdc:Bounds x="892" y="549" width="57" height="27" />
        </bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNEdge id="SequenceFlow_0y8twcv_di" bpmnElement="SequenceFlow_0y8twcv">
        <di:waypoint x="795" y="524" />
        <di:waypoint x="902" y="524" />
        <bpmndi:BPMNLabel>
          <omgdc:Bounds x="832" y="506" width="34" height="14" />
        </bpmndi:BPMNLabel>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNShape id="EndEvent_0zv54kr_di" bpmnElement="EndEvent_0zv54kr">
        <omgdc:Bounds x="870" y="352" width="36" height="36" />
        <bpmndi:BPMNLabel>
          <omgdc:Bounds x="863" y="395" width="51" height="14" />
        </bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNEdge id="SequenceFlow_0yrmgpx_di" bpmnElement="SequenceFlow_0yrmgpx">
        <di:waypoint x="820" y="370" />
        <di:waypoint x="870" y="370" />
      </bpmndi:BPMNEdge>
    </bpmndi:BPMNPlane>
    <bpmndi:BPMNLabelStyle id="sid-e0502d32-f8d1-41cf-9c4a-cbb49fecf581">
      <omgdc:Font name="Arial" size="11" isBold="false" isItalic="false" isUnderline="false" isStrikeThrough="false" />
    </bpmndi:BPMNLabelStyle>
    <bpmndi:BPMNLabelStyle id="sid-84cb49fd-2f7c-44fb-8950-83c3fa153d3b">
      <omgdc:Font name="Arial" size="12" isBold="false" isItalic="false" isUnderline="false" isStrikeThrough="false" />
    </bpmndi:BPMNLabelStyle>
  </bpmndi:BPMNDiagram>
</definitions>'
        ]);
    }
}
