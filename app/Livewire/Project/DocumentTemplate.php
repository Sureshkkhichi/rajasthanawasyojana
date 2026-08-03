<?php

namespace App\Livewire\Project;

use App\Models\Project;
use App\Models\FrontendSetting;
use Livewire\Component;

class DocumentTemplate extends Component
{
    public $selectedProjectId = '';
    public $projects = [];
    public $activeTab = 'allotmentTab';

    // Allotment Letter Fields
    public $allotment_subtitle = '';
    public $allotment_subject = '';
    public $allotment_body = '';
    public $allotment_table_title = '';
    public $allotment_footer_note = '';
    public $allotment_sign_off = '';
    public $allotment_registered_office = '';

    // Demand Letter Fields
    public $demand_subtitle = '';
    public $demand_subject = '';
    public $demand_salutation = '';
    public $demand_body = '';
    public $demand_inst1_label = '';
    public $demand_inst2_label = '';
    public $demand_footer_para = '';
    public $demand_bank_account_holder = '';
    public $demand_bank_name = '';
    public $demand_bank_account_no = '';
    public $demand_bank_ifsc = '';
    public $demand_bank_address = '';
    public $demand_sign_off = '';
    public $demand_registered_office = '';
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
        $this->allotment_subtitle = FrontendSetting::getVal("project_{$pid}_allotment_subtitle", 'हर परिवार का सपना, हमारा संकल्प');
        $this->allotment_subject = FrontendSetting::getVal("project_{$pid}_allotment_subject", 'आवंटन पत्र');
        $this->allotment_body = FrontendSetting::getVal("project_{$pid}_allotment_body", "हमें यह सूचित करते हुए हर्ष हो रहा है कि मुख्यमंत्री जन आवास योजना के अंतर्गत हमारी आवासीय परियोजना \"{PROJECT_NAME}\" (टावर – {BLOCK_TOWER}) में आपको निम्न विवरणानुसार आवासीय इकाई ({UNIT_TYPE}) का आवंटन किया गया है।");

        $this->allotment_table_title = FrontendSetting::getVal("project_{$pid}_allotment_table_title", 'आवंटन विवरण');
        $this->allotment_footer_note = FrontendSetting::getVal("project_{$pid}_allotment_footer_note", "यह आवंटन निम्न शर्तों के अधीन होगा कि आप पात्रता, दस्तावेज सत्यापन तथा भुगतान सारणी के अनुसार आवश्यक सभी भुगतान निर्धारित समय सीमा में पूर्ण करेंगे ।\nकृपया इस पत्र को सुरक्षित रखें तथा आगामी किस्त जमा करें ।");
        $this->allotment_sign_off = FrontendSetting::getVal("project_{$pid}_allotment_sign_off", 'भवदीय,');
        $this->allotment_registered_office = FrontendSetting::getVal("project_{$pid}_allotment_registered_office", '12/456, विनायक पथ, मानसरोवर, जयपुर - 302020 (राज.)');

        // Demand Letter Settings
        $this->demand_subtitle = FrontendSetting::getVal("project_{$pid}_demand_subtitle", 'जयपुर विकास प्राधिकरण द्वारा अनुमोदित');
        $this->demand_subject = FrontendSetting::getVal("project_{$pid}_demand_subject", 'विषय: भूखण्ड संख्या {UNIT_NO} की बकाया राशि जमा कराने बाबत।');
        $this->demand_salutation = FrontendSetting::getVal("project_{$pid}_demand_salutation", 'महोदय / महोदया,');
        $this->demand_body = FrontendSetting::getVal("project_{$pid}_demand_body", "{$projectName} में आवेदन पत्र संख्या {FORM_NO} के द्वारा आपने भूखण्ड आवंटन किये जाने हेतु बुकिंग कराई थी, आपको आवंटित भूखण्ड एवं उसके विक्रय प्रतिफल के पेटे जमा कराई जाने वाली राशि का विवरण निम्न प्रकार है:-");
        $this->demand_inst1_label = FrontendSetting::getVal("project_{$pid}_demand_inst1_label", '1 Installment 10%');
        $this->demand_inst2_label = FrontendSetting::getVal("project_{$pid}_demand_inst2_label", '2 Installment 90%');
        $this->demand_footer_para = FrontendSetting::getVal("project_{$pid}_demand_footer_para", "अतः आपसे अनुरोध है कि इस मांग पत्र के जारी होने की दिनांक से उक्तानुसार राशि जमा करावे अथवा लोन के लिए बैंक एवं फर्म द्वारा मांगे गए दस्तावेज, {PROJECT_ADDRESS} स्थित कार्यालय में स्वयं उपस्थित होकर जमा करावे। यदि किसी भी कारण से आप द्वारा उक्त राशि निर्धारित समयावधि में जमा नहीं कराई गयी तो बकाया राशि पर 18 प्रतिशत वार्षिक ब्याज की दर से ब्याज जमा कराना होगा。\n\nराशि के चेक / आरटीजीएस / एनईएफटी / आईएमपीएस / ऑनलाइन {PROJECT_NAME} के नाम से देय होंगे, बैंक का विवरण निम्न प्रकार है:-");
        $this->demand_bank_account_holder = FrontendSetting::getVal("project_{$pid}_demand_bank_account_holder", 'ACL INFRATECH PRIVATE LIMITED LOVE HOME JOYPUR COLLECTION AC');
        $this->demand_bank_name = FrontendSetting::getVal("project_{$pid}_demand_bank_name", 'STATE BANK OF INDIA');
        $this->demand_bank_account_no = FrontendSetting::getVal("project_{$pid}_demand_bank_account_no", '43565607058');
        $this->demand_bank_ifsc = FrontendSetting::getVal("project_{$pid}_demand_bank_ifsc", 'SBIN0004080');
        $this->demand_bank_address = FrontendSetting::getVal("project_{$pid}_demand_bank_address", 'SME Branch Church Road, Jaipur');
        $this->demand_sign_off = FrontendSetting::getVal("project_{$pid}_demand_sign_off", 'भवदीय,');
        $this->demand_registered_office = FrontendSetting::getVal("project_{$pid}_demand_registered_office", '12/456, विनायक पथ, मानसरोवर, जयपुर - 302020 (राज.)');
        $this->demand_footer_note = FrontendSetting::getVal("project_{$pid}_demand_footer_note", 'नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।');
    }

    public function saveSettings()
    {
        $this->validate([
            'selectedProjectId' => 'required|exists:projects,id',
            'allotment_subtitle' => 'required|string',
            'allotment_subject' => 'required|string',
            'allotment_body' => 'required|string',
            'allotment_table_title' => 'required|string',
            'allotment_footer_note' => 'required|string',
            'allotment_sign_off' => 'required|string',
            'allotment_registered_office' => 'nullable|string',
            'demand_subtitle' => 'required|string',
            'demand_subject' => 'required|string',
            'demand_salutation' => 'required|string',
            'demand_body' => 'required|string',
            'demand_inst1_label' => 'required|string',
            'demand_inst2_label' => 'required|string',
            'demand_footer_para' => 'required|string',
            'demand_bank_account_holder' => 'nullable|string',
            'demand_bank_name' => 'nullable|string',
            'demand_bank_account_no' => 'nullable|string',
            'demand_bank_ifsc' => 'nullable|string',
            'demand_bank_address' => 'nullable|string',
            'demand_sign_off' => 'required|string',
            'demand_registered_office' => 'nullable|string',
            'demand_footer_note' => 'required|string',
        ]);

        $pid = $this->selectedProjectId;

        FrontendSetting::setVal("project_{$pid}_allotment_subtitle", $this->allotment_subtitle);
        FrontendSetting::setVal("project_{$pid}_allotment_subject", $this->allotment_subject);
        FrontendSetting::setVal("project_{$pid}_allotment_body", $this->allotment_body);
        FrontendSetting::setVal("project_{$pid}_allotment_table_title", $this->allotment_table_title);
        FrontendSetting::setVal("project_{$pid}_allotment_footer_note", $this->allotment_footer_note);
        FrontendSetting::setVal("project_{$pid}_allotment_sign_off", $this->allotment_sign_off);
        FrontendSetting::setVal("project_{$pid}_allotment_registered_office", $this->allotment_registered_office);

        FrontendSetting::setVal("project_{$pid}_demand_subtitle", $this->demand_subtitle);
        FrontendSetting::setVal("project_{$pid}_demand_subject", $this->demand_subject);
        FrontendSetting::setVal("project_{$pid}_demand_salutation", $this->demand_salutation);
        FrontendSetting::setVal("project_{$pid}_demand_body", $this->demand_body);
        FrontendSetting::setVal("project_{$pid}_demand_inst1_label", $this->demand_inst1_label);
        FrontendSetting::setVal("project_{$pid}_demand_inst2_label", $this->demand_inst2_label);
        FrontendSetting::setVal("project_{$pid}_demand_footer_para", $this->demand_footer_para);
        FrontendSetting::setVal("project_{$pid}_demand_bank_account_holder", $this->demand_bank_account_holder);
        FrontendSetting::setVal("project_{$pid}_demand_bank_name", $this->demand_bank_name);
        FrontendSetting::setVal("project_{$pid}_demand_bank_account_no", $this->demand_bank_account_no);
        FrontendSetting::setVal("project_{$pid}_demand_bank_ifsc", $this->demand_bank_ifsc);
        FrontendSetting::setVal("project_{$pid}_demand_bank_address", $this->demand_bank_address);
        FrontendSetting::setVal("project_{$pid}_demand_sign_off", $this->demand_sign_off);
        FrontendSetting::setVal("project_{$pid}_demand_registered_office", $this->demand_registered_office);
        FrontendSetting::setVal("project_{$pid}_demand_footer_note", $this->demand_footer_note);

        session()->flash('success', 'PDF Document template content updated successfully for the selected project.');

        $this->dispatch('scroll-to-top');

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

        $this->allotment_subtitle = 'हर परिवार का सपना, हमारा संकल्प';
        $this->allotment_subject = 'आवंटन पत्र';
        $this->allotment_body = "हमें यह सूचित करते हुए हर्ष हो रहा है कि मुख्यमंत्री जन आवास योजना के अंतर्गत हमारी आवासीय परियोजना \"{PROJECT_NAME}\" ({BLOCK_TOWER}) में आपको निम्न विवरणानुसार आवासीय इकाई ({UNIT_TYPE}) का आवंटन किया गया है।";
        $this->allotment_footer_note = "यह आवंटन निम्न शर्तों के अधीन होगा कि आप पात्रता, दस्तावेज सत्यापन तथा भुगतान सारणी के अनुसार आवश्यक सभी भुगतान निर्धारित समय सीमा में पूर्ण करेंगे ।\nकृपया इस पत्र को सुरक्षित रखें तथा भुगतान सारणी के अनुसार आगामी किस्त जमा करें ।";

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
