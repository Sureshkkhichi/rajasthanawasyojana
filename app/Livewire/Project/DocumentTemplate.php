<?php

namespace App\Livewire\Project;

use App\Models\Project;
use App\Models\FrontendSetting;
use Livewire\Component;

class DocumentTemplate extends Component
{
    public $selectedProjectId = '';
    public $projects = [];

    // Allotment Letter Fields
    public $allotment_subtitle = '';
    public $allotment_subject = '';
    public $allotment_body = '';
    public $allotment_footer_note = '';

    // Demand Letter Fields
    public $demand_subtitle = '';
    public $demand_subject = '';
    public $demand_body = '';
    public $demand_footer_para = '';
    public $demand_footer_note = '';

    public function mount()
    {
        $this->projects = Project::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        if ($this->projects->isNotEmpty()) {
            $this->selectedProjectId = $this->projects->first()->id;
            $this->loadSettings();
        }
    }

    public function updatedSelectedProjectId($value)
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        if (!$this->selectedProjectId) {
            return;
        }

        $pid = $this->selectedProjectId;
        $project = Project::find($pid);
        $projectName = $project ? $project->name : '{PROJECT_NAME}';

        // Allotment Letter Settings
        $this->allotment_subtitle = FrontendSetting::getVal("project_{$pid}_allotment_subtitle", 'जयपुर विकास प्राधिकरण द्वारा अनुमोदित');
        $this->allotment_subject = FrontendSetting::getVal("project_{$pid}_allotment_subject", 'विषय:- आवासीय भूखण्ड \ फ्लैट \ व्यवसायिक भूखण्ड आवंटन की सूचना बाबत !');
        $this->allotment_body = FrontendSetting::getVal("project_{$pid}_allotment_body", "हमें यह उद्घोषित करते हुए प्रसन्नता हो रही है कि हमारी योजना {$projectName} में आपका भूखण्ड \ फ्लैट का आवंटित किया जाना प्रस्तावित है जिसका विवरण निम्न प्रकार से है:");
        $this->allotment_footer_note = FrontendSetting::getVal("project_{$pid}_allotment_footer_note", 'नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।');

        // Demand Letter Settings
        $this->demand_subtitle = FrontendSetting::getVal("project_{$pid}_demand_subtitle", 'जयपुर विकास प्राधिकरण द्वारा अनुमोदित');
        $this->demand_subject = FrontendSetting::getVal("project_{$pid}_demand_subject", 'विषय: भूखण्ड संख्या {UNIT_NO} की बकाया राशि जमा कराने बाबत।');
        $this->demand_body = FrontendSetting::getVal("project_{$pid}_demand_body", "{$projectName} में आवेदन पत्र संख्या {FORM_NO} के द्वारा आपने भूखण्ड आवंटन किये जाने हेतु बुकिंग कराई थी, आपको आवंटित भूखण्ड एवं उसके विक्रय प्रतिफल के पेटे जमा कराई जाने वाली राशि का विवरण निम्न प्रकार है:-");
        $this->demand_footer_para = FrontendSetting::getVal("project_{$pid}_demand_footer_para", "अतः आपसे अनुरोध है कि इस मांग पत्र के जारी होने की दिनांक से उक्तानुसार राशि जमा करावे अथवा लोन के लिए बैंक एवं फर्म द्वारा मांगे गए दस्तावेज, {PROJECT_ADDRESS} स्थित कार्यालय में स्वयं उपस्थित होकर जमा करावे। यदि किसी भी कारण से आप द्वारा उक्त राशि निर्धारित समयावधि में जमा नहीं कराई गयी तो बकाया राशि पर 18 प्रतिशत वार्षिक ब्याज की दर से ब्याज जमा कराना होगा。\n\nराशि के चेक / आरटीजीएस / एनईएफटी / आईएमपीएस / ऑनलाइन {$projectName} के नाम से देय होंगे।");
        $this->demand_footer_note = FrontendSetting::getVal("project_{$pid}_demand_footer_note", 'नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।');
    }

    public function saveSettings()
    {
        $this->validate([
            'selectedProjectId' => 'required|exists:projects,id',
            'allotment_subtitle' => 'required|string',
            'allotment_subject' => 'required|string',
            'allotment_body' => 'required|string',
            'allotment_footer_note' => 'required|string',
            'demand_subtitle' => 'required|string',
            'demand_subject' => 'required|string',
            'demand_body' => 'required|string',
            'demand_footer_para' => 'required|string',
            'demand_footer_note' => 'required|string',
        ]);

        $pid = $this->selectedProjectId;

        FrontendSetting::setVal("project_{$pid}_allotment_subtitle", $this->allotment_subtitle);
        FrontendSetting::setVal("project_{$pid}_allotment_subject", $this->allotment_subject);
        FrontendSetting::setVal("project_{$pid}_allotment_body", $this->allotment_body);
        FrontendSetting::setVal("project_{$pid}_allotment_footer_note", $this->allotment_footer_note);

        FrontendSetting::setVal("project_{$pid}_demand_subtitle", $this->demand_subtitle);
        FrontendSetting::setVal("project_{$pid}_demand_subject", $this->demand_subject);
        FrontendSetting::setVal("project_{$pid}_demand_body", $this->demand_body);
        FrontendSetting::setVal("project_{$pid}_demand_footer_para", $this->demand_footer_para);
        FrontendSetting::setVal("project_{$pid}_demand_footer_note", $this->demand_footer_note);

        $this->dispatch('swal:alert', [
            'title' => 'Settings Saved!',
            'text' => 'PDF Document template content updated successfully for the selected project.',
            'icon' => 'success'
        ]);
    }

    public function resetToDefault()
    {
        if (!$this->selectedProjectId) {
            return;
        }

        $pid = $this->selectedProjectId;
        $project = Project::find($pid);
        $projectName = $project ? $project->name : '{PROJECT_NAME}';

        $this->allotment_subtitle = 'जयपुर विकास प्राधिकरण द्वारा अनुमोदित';
        $this->allotment_subject = 'विषय:- आवासीय भूखण्ड \ फ्लैट \ व्यवसायिक भूखण्ड आवंटन की सूचना बाबत !';
        $this->allotment_body = "हमें यह उद्घोषित करते हुए प्रसन्नता हो रही है कि हमारी योजना {$projectName} में आपका भूखण्ड \ फ्लैट का आवंटित किया जाना प्रस्तावित है जिसका विवरण निम्न प्रकार से है:";
        $this->allotment_footer_note = 'नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।';

        $this->demand_subtitle = 'जयपुर विकास प्राधिकरण द्वारा अनुमोदित';
        $this->demand_subject = 'विषय: भूखण्ड संख्या {UNIT_NO} की बकाया राशि जमा कराने बाबत।';
        $this->demand_body = "{$projectName} में आवेदन पत्र संख्या {FORM_NO} के द्वारा आपने भूखण्ड आवंटन किये जाने हेतु बुकिंग कराई थी, आपको आवंटित भूखण्ड एवं उसके विक्रय प्रतिफल के पेटे जमा कराई जाने वाली राशि का विवरण निम्न प्रकार है:-";
        $this->demand_footer_para = "अतः आपसे अनुरोध है कि इस मांग पत्र के जारी होने की दिनांक से उक्तानुसार राशि जमा करावे अथवा लोन के लिए बैंक एवं फर्म द्वारा मांगे गए दस्तावेज, {PROJECT_ADDRESS} स्थित कार्यालय में स्वयं उपस्थित होकर जमा करावे। यदि किसी भी कारण से आप द्वारा उक्त राशि निर्धारित समयावधि में जमा नहीं कराई गयी तो बकाया राशि पर 18 प्रतिशत वार्षिक ब्याज की दर से ब्याज जमा कराना होगा。\n\nराशि के चेक / आरटीजीएस / एनईएफटी / आईएमपीएस / ऑनलाइन {$projectName} के नाम से देय होंगे।";
        $this->demand_footer_note = 'नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।';

        $this->saveSettings();
    }

    public function render()
    {
        return view('livewire.project.document-template')
            ->layout('layouts.app');
    }
}
