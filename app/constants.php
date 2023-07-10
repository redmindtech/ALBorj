
<?php
// SITE MASTER DROPDOWN
const SITESTATUS= [
'Started'   => 'Started',
'Hold on'   => 'Hold on',
'Progress'  => 'Progress',
'Completed' =>  'Completed',
'Testing & Commissioning'   => 'Testing & Commissioning',
'Closed'    =>  'Closed'
];
const SITELOCATION= [
    'Abu Dhabi' => 'Abu Dhabi',
    'Ajman' => 'Ajman',
    'Dubai' => 'Dubai',
    'Fujairah' => 'Fujairah',
    'Ras Al Khaimah' => 'Ras Al Khaimah',
    'Sharjah' => 'Sharjah',
    'Umm Al Quwain' => 'Umm Al Quwain',
];
//  PROJECT MASTER DROPDOWM
const PROJECT_TYPE=[
'Project'=>'Project',
'Repair & Maintenance'=> 'Repair & Maintenance',
'Annual maintenance contract'=>'Annual maintenance contract',
'Man power supply'=>'Man power supply'
];
const PROJECT_STATUS=[
'Started' =>'Started',
'Hold on'=>'Hold on',
'Progress'=>'Progress',
'Completed'=>'Completed',
'Testing & Commissioning'=>'Testing & Commissioning',
'Closed'=>'Closed'
];
// emp master
const CATEGORY= [
    'Staff' => 'Staff',
    'Labour' => 'Labour'
];
const WORKING_AS= [
    'operation manager' => 'operation manager',
    'a/c mechanic assistant' => 'a/c mechanic assistant',
    'pipe fitter' => 'pipe fitter',
    'air conditioning assistant' => 'air conditioning assistant',
    'purchaser' => 'purchaser',
    'plumber' => 'plumber',
    'electrical foremen' => 'electrical foremen',
    'projects engineer' => 'projects engineer',
    'construction worker' => 'construction worker',
    'welder' => 'welder',
    'painter' => 'painter',
    'office' => 'office',
    'messenger' => 'messenger',
    'archive clerk' => 'archive clerk',
    'light vehicle deriver' => 'light vehicle deriver',
];

const SPONSOR=[
    'Al Borj Al Mumtaz tech cont' => 'Al Borj Al Mumtaz tech cont',
    'RedMind Tech' => 'RedMind Tech'

];

const DEPARTMENT=[
    'General'=>'General',
    'General staff' => 'General staff',
    'Electrical department' => 'Electrical department',
    'hvac department' => 'hvac department',
    'Buildmax' => 'Buildmax',
    'Foreman - hvac' => 'Foreman - hvac',
    'hvac technician' => 'hvac technician',
    'Ultra' => 'Ultra',
    'al nuaimi' => 'al nuaimi',
    'rk gulf' => 'rk gulf',
    'welder' => 'welder',
    'painter' => 'painter',
];

const STATUS=[
    'Working'=>'Working',
    'On leave' => 'On leave',
    'Vacation' => 'Vacation',
    'Long Leave' => 'Long Leave',
    'Resigned' => 'Resigned',
    'Termination' => 'Termination',

];

const RELIGIONS=[
    'Christianity' => 'Christianity',
    'Islam' => 'Islam',
    'Hinduism' => 'Hinduism',
    'Buddhism' => 'Buddhism',
    'Folk relegions' => 'Folk relegions',
    'Sikhism' => 'Sikhism',
    'Other religions' => 'Other religions',

];

const NATIONALITY = [
    'Indian' => 'Indian',
    'Pakistani' => 'Pakistani',
    'Bangladeshi' => 'Bangladeshi',
    'Emirati' => 'Emirati',
    'African' => 'African',
    'Sri lankan' => 'Sri lankan',

];
const LOCATION=[
    'Sharjah Camp' => 'Sharjah Camp',
    'Ras Al Khaimah Camp' => 'Ras Al Khaimah Camp',
    'Dubai Camp' => 'Dubai Camp',
];
const VISA_STATUS =[
    'Active' => 'Active',
    'Expired' => 'Expired',
];
const PAY_GROUP=[
    'Staff group' => 'Staff group',
    'Hourly Salary' => 'Hourly Salary',
    'Fixed Salary + OT' => 'Fixed Salary + OT',
];
const  ACCOMODATION =[
    'Sharjah Camp' => 'Sharjah Camp',
    'Ras Al Khaimah Camp' => 'Ras Al Khaimah Camp',
    'Abu Dubai Camp' => 'Dubai Camp',
    'Buildmax Camp' => 'Buildmax Camp',
];
const DESIGNATION=[
    'Investor' => 'Investor',
    'Administration Manager' => 'Administration Manager',
    'General Manager' => 'General Manager',
];

// item Master
const ITEMTYPE= [
    'Conduits & bends' => 'Conduits & bends',
    'Junction boxes' => 'Junction boxes',
    'Switches and Plates' => 'Switches and Plates',
    'Elbow Pipe Fittings' => 'Elbow Pipe Fittings',
    'Reducer Pipe Fittings' => 'Reducer Pipe Fittings',
    ];
    const ITEMCATEGORY= [
        'Electrical Works' => 'Electrical Works',
        'Plumbing Works' => 'Plumbing Works',
        ];
    const ITEMSUBCATEGORY =[
        'Electrical Items' =>
        [
    
            'Extension Cords' => 'Extension Cords',
            'Switches & Dimmers'=>'Switches & Dimmers',
            'Electrical Wire'=>'Electrical Wire',
            'Cord Management'=>'Cord Management',
            'Electrical Connectors'=>'Electrical Connectors',
            'Adapters & Multi-Outlets'=>'Adapters & Multi-Outlets',
            'Electric Motors'=>'Electric Motors',
            'Tools & Testers'=>'Tools & Testers',
        ],
        'Plumbing Items'=>
        [
            'Barb' => 'Barb',
            'Coupling'=>'Coupling',
            'Cross'=>'Cross',
            'Elbow'=>'Elbow',
            'Mechanical Sleeve'=>'Mechanical Sleeve',
            'Adapter'=>'Adapter',
            'Reducer'=>'Reducer',
        ],
    
    ];
const STOCKTYPE= [
    'Common Stock' => 'Common Stock',
    'Preferred Stock' => 'Preferred Stock',
    'Large-cap Stock' => 'Large-cap Stock',
    'Mid-cap Stock' => 'Mid-cap Stock',
];

// Expenses
const SOURCE=[
    'Cash'    => 'Cash',
    'Card'    => 'Card',
    'Transfer'=> 'Transfer',
    'Cheque'  => 'Cheque',
];
const VAT=[
    '0'  => '0',
    '5'  => '5'
];
// grn project type
const GRNPURCHASETYPE=[
    'Local Purchase Order'=>'Local Purchase Order',
   'Non Inventory purchase order'=>'Non Inventory purchase order',
    'Hire order'=>'Hire order',
    'Asset and miscellaneous order'=>'Asset and miscellaneous order',
    'Cash purchase'=>'Cash purchase'];
    // material issue
    const MATERIALTYPE= [
        'Issue' => 'Issue',
        'Return' => 'Return',
    
    ];
    //PURCHASE ORDER
const CURRENCY= [
    'AED' => 'AED',
    'INR' => 'INR',

];
const PROJECTORDERTYPE= [
    'Local Purchase Order' => 'Local Purchase Order',
    'Non Inventory Purchase Order' => 'Non Inventory Purchase Order',
    'Hire Order' => 'Hire Order',
    'Asset and miscellaneous Order' => 'Asset and miscellaneous Order',
    'Cash Purchase' => 'Cash Purchase',
];
//payroll
const PAYMENT_MODE= [
    'Cash' => 'Cash',
    'UPI' => 'UPI',
    'WPS' => 'WPS',

];
const MONTH = [
    '1' => 'January',
    '2' => 'February',
    '3' => 'March',
    '4' => 'April',
    '5' => 'May',
    '6' => 'June',
    '7' => 'July',
    '8' => 'August',
    '9' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December',
];
const REPORT_MONTH =[

    '-01-01 to -03-31'=>'01 January to 31 March',
    '-04-01 to -06-30'=>'01 April to 30 June',
    '-07-01 to -09-30'=>'01 July to 30 September',
    '-10-01 to -12-31'=>'01 October to 31 December',
];const REPORT_YEARS =[

    '2000'=>'2000',
    '2001'=>'2001',
    '2002'=>'2002',
    '2003'=>'2003',
    '2004'=>'2004',
    '2005'=>'2005',
    '2006'=>'2006',
    '2007'=>'2007',
    '2008'=>'2008',
    '2009'=>'2009',
    '2010'=>'2010',
    '2011'=>'2011',
    '2012'=>'2012',
    '2013'=>'2013',
    '2014'=>'2014',
    '2015'=>'2015',
    '2016'=>'2016',
    '2017'=>'2017',
    '2018'=>'2018',
    '2019'=>'2019',
    '2020'=>'2020',
    '2021'=>'2021',
    '2022'=>'2022',
    '2023'=>'2023'
];

?>