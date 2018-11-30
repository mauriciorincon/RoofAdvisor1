<?php
class usefullURLS{


    public function fillInfoUrls(){
        $data_array=array(
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Aventura","url"=>"https://www.cityofaventura.com/169/Building-Permits"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Coral Gables","url"=>"https://www.coralgables.com/departments/DevelopmentServices/building-division"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"City of Miami ","url"=>"http://www.miamigov.com/Building/"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Doral","url"=>"https://www.cityofdoral.com/all-departments/building/permit-information/"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Florida City","url"=>"http://www.floridacityfl.gov/"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Hialeah","url"=>"http://www.hialeahfl.gov/154/Building"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Hialeah Gardens","url"=>"http://www.cityofhialeahgardens.com/cohg2/"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Homestead","url"=>"https://www.cityofhomestead.com/148/Building-Permits"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Miami-Dade","url"=>"http://www.miamidade.gov/permits/"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Miami Beach","url"=>"https://www.miamibeachfl.gov/city-hall/building/"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Miami Gardens","url"=>"https://www.miamigardens-fl.gov/"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Miami Springs","url"=>"https://www.miamisprings-fl.gov/building"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"North Bay Village","url"=>"https://www.nbvillage.com/"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"North Miami","url"=>"http://www.northmiamifl.gov/northmiamifl/departments/building/"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"North Miami Beach","url"=>"https://www.citynmb.com/149/Building-Division"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Opa-locka","url"=>"http://www.opalockafl.gov/index.aspx?nid=73"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"South Miami","url"=>"https://www.southmiamifl.gov/244/Permits-Inspections"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Sunny Isles Beach","url"=>"https://www.sibfl.net/building-dept/"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Sweetwater","url"=>"http://www.cityofsweetwater.fl.gov/building-zoning.html"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"West Miami","url"=>"https://cityofwestmiamifl.com/index.asp?SEC=FC973A77-51B1-4B37-9C4C-01F340DE723D&Type=B_BASIC"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Pinecrest","url"=>"https://www.pinecrest-fl.gov/government/building-planning"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Surfside","url"=>"https://www.townofsurfsidefl.gov/departments-services/building"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Miami Lakes","url"=>"https://www.miamilakes-fl.gov/index.php?option=com_content&view=article&id=7&Itemid=138"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Medlly","url"=>"http://www.townofmedley.com/building-and-zoning-department"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Cutler Bay","url"=>"http://cutlerbay-fl.gov/departments/community-development/building-"),
            array("state"=>"Florida","city"=>"Miami-Dade County","place"=>"Key Biscayne","url"=>"http://keybiscayne.fl.gov/index.php?submenu=_building&src=gendocs&ref=BuildingZoningPlanning&category=DeptsSvcs"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Coconut Creek","url"=>"https://www.coconutcreek.net/sd/building-department"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Cooper City","url"=>"https://www.coopercityfl.org/"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Coral Springs","url"=>"https://www.coralsprings.org/government/other-departments-and-services/building"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Dania Beach","url"=>"https://daniabeachfl.gov/125/Building-Division"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Davie","url"=>"https://www.davie-fl.gov/206/Building"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Deerfield Beach","url"=>"https://www.deerfield-beach.com/294/Building-Services"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Fort Lauderdale","url"=>"https://www.fortlauderdale.gov/departments/sustainable-development/building-services"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Hallandale Beach","url"=>"https://hallandalebeachfl.gov/1031/Forms"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Hillsboro Beach","url"=>"https://www.townofhillsborobeach.com/196/Building-Department"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Hollywood","url"=>"https://www.hollywoodfl.org/328/Building"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Lauderdale-by-the-Sea","url"=>"http://www.lauderdalebythesea-fl.gov/dev/buildingpage.htm"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Lauderdale Lakes","url"=>"https://www.lauderdalelakes.org/160/Building"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Lauderhill","url"=>"https://www.lauderhill-fl.gov/departments"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Lighthouse Point","url"=>"https://city.lighthousepoint.com/building-and-zoning/"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Margate","url"=>"https://www.margatefl.com/196/Building"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Miramar","url"=>"https://www.miramarfl.gov/150/Building-Permits-Inspections"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"North Lauderdale","url"=>"http://www.nlauderdale.org/departments/community_development/index.php"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Oakland Park","url"=>"https://oaklandparkfl.gov/172/Building-Permit-Applications-Forms"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Parkland","url"=>"https://www.cityofparkland.org/109/Building-Division"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Pembroke Park","url"=>"http://www.townofpembrokepark.com/departments/building-department-applications-forms/"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Pembroke Pines","url"=>"https://www.ppines.com/164/Building-Department"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Plantation","url"=>"http://www.plantation.org/Building/"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Pompano Beach","url"=>"http://pompanobeachfl.gov/pages/dev_scv_building_inspections/building_inspections"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Southwest Ranches","url"=>"http://www.southwestranches.org/departments/building-permits/"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Sunrise","url"=>"https://www.sunrisefl.gov/index.aspx?page=97"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Tamarac","url"=>"https://www.tamarac.org/134/Permits-Inspections"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"West Park","url"=>"https://web.cityofwestpark.net/departments-2/building-department"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Weston","url"=>"https://www.westonfl.org/government/building-code-and-permitting-services"),
            array("state"=>"Florida","city"=>"Broward County","place"=>"Wilton Manors","url"=>"https://www.wiltonmanors.com/133/Building-Permit-Applications"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Atlantis","url"=>"https://www.atlantisfl.gov/building-department/pages/building-department-forms"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Belle Glade","url"=>"http://www.bellegladegov.com/index.php?option=com_content&view=article&id=92&Itemid=78"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Boca Raton","url"=>"https://www.myboca.us/1186/Licensing-Permitting"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Boynton Beach","url"=>"https://www.boynton-beach.org/permits"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Briny Breezes","url"=>"http://townofbrinybreezes-fl.com/licenses_permits_fees/licenses_permits_fees.htm"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Delray Beach","url"=>"http://www.mydelraybeach.com/departments/community_improvement/building_codes_and_ordinances.php"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Golf","url"=>"http://www.villageofgolf.org/major-construction"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Greenacres","url"=>"https://greenacresfl.gov/building"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Gulf Stream","url"=>"https://www.gulf-stream.org/"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Haverhill","url"=>"https://www.townofhaverhill-fl.gov/building"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Highland Beach","url"=>"https://highlandbeach.us/departments/building-department/"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Hypoluxo","url"=>"http://www.hypoluxo.org/256541.html"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Juno Beach","url"=>"https://www.juno-beach.fl.us/"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Jupiter","url"=>"https://www.jupiter.fl.us/93/Building"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Jupiter Inlet Colony","url"=>"http://www.jupiterinletcolony.org/building-department.html"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Lake Clarke Shores","url"=>"http://www.townoflakeclarkeshores.com/service/permits-and-licenses"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Lake Park","url"=>"https://www.lakeparkflorida.gov/cdd"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Lake Worth","url"=>"https://www.lakeworth.org/business/permits/"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Lantana","url"=>"https://www.lantana.org/building-permits"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Loxahatchee Groves","url"=>"http://www.loxahatcheegrovesfl.gov/forms"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Manalapan","url"=>"https://www.manalapan.org/index.aspx?nid=478"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Mangonia Park","url"=>"http://www.townofmangoniapark.com/departments/buildingplanningzoning.html"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"North Palm Beach","url"=>"https://www.village-npb.org/149/Building-Division"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Ocean Ridge","url"=>"http://www.oceanridgeflorida.com/"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Pahokee","url"=>"http://www.cityofpahokee.com/Pages/PahokeeFL_Building/index"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Palm Beach","url"=>"https://www.townofpalmbeach.com/284/Planning-Zoning-Building"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Palm Beach Gardens","url"=>"https://www.pbgfl.com/159/Planning-Zoning"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Palm Beach Shores","url"=>"http://www.palmbeachshoresfl.us/departments/building_department/index.php"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Palm Springs","url"=>"https://vpsfl.org/index.aspx?NID=288"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Riviera Beach","url"=>"http://www.rivierabch.com/content/24503/24519/default.aspx"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Royal Palm Beach","url"=>"https://www.royalpalmbeach.com/index.aspx?NID=84"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"South Bay","url"=>"http://www.southbaycity.com/Public_Documents/index"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"South Palm Beach","url"=>"http://www.southpalmbeach.com/247261.html"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Tequesta","url"=>"https://www.tequesta.org/1204/Building-Department"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Wellington","url"=>"https://www.wellingtonfl.gov/government/departments/planning-zoning"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"Westlake","url"=>"https://www.westlakegov.com/"),
            array("state"=>"Florida","city"=>"Palm Beach County","place"=>"West Palm Beach","url"=>"http://wpb.org/Departments/Development-Services/Construction/Overview"),
            array("state"=>"Florida","city"=>"Monroe County","place"=>"Key West","url"=>"https://www.cityofkeywest-fl.gov/department/index.php?structureid=1"),
            array("state"=>"Florida","city"=>"Monroe County","place"=>"Marathon","url"=>"http://www.ci.marathon.fl.us/government/departments/building/"),
            array("state"=>"Florida","city"=>"Monroe County","place"=>"Key Colony Beach","url"=>"https://keycolonybeach.net/"),
            array("state"=>"Florida","city"=>"Monroe County","place"=>"Layton","url"=>"http://www.laytoncity.org/LC/CD/BuildingDivision"),
            array("state"=>"Florida","city"=>"Monroe County","place"=>"Key Largo","url"=>"https://www.monroecounty-fl.gov/149/Building"),
            array("state"=>"Rhode Island","city"=>"Bristol","place"=>"Barrington","url"=>"http://www.barrington.ri.gov/departments/buildingandzoning.php"),
            array("state"=>"Rhode Island","city"=>"Bristol","place"=>"Bristol","url"=>"https://www.bristolri.us/325/Community-Development-Building-Zoning-Pl"),
            array("state"=>"Rhode Island","city"=>"Bristol","place"=>"Warren","url"=>"http://www.townofwarren-ri.gov/departmentsaz/buildingandzoning.html"),
            array("state"=>"Rhode Island","city"=>"Kent","place"=>"Coventry","url"=>"https://www.coventryri.org/planning-development"),
            array("state"=>"Rhode Island","city"=>"Kent","place"=>"East Greenwich","url"=>"https://www.eastgreenwichri.com/165/Building-Permits-Information"),
            array("state"=>"Rhode Island","city"=>"Kent","place"=>"Warwick","url"=>"https://www.warwickri.gov/building-department"),
            array("state"=>"Rhode Island","city"=>"Kent","place"=>"West Greenwich","url"=>"https://www.wgtownri.org/inspectors-zoning/pages/building-department"),
            array("state"=>"Rhode Island","city"=>"Kent","place"=>"West Warwick","url"=>"https://www.westwarwickri.org/"),
            array("state"=>"Rhode Island","city"=>"Newport","place"=>"Jamestown","url"=>"http://www.jamestownri.gov/town-departments/building-zoning"),
            array("state"=>"Rhode Island","city"=>"Newport","place"=>"Little Compton","url"=>"http://www.little-compton.com/dept.php#building"),
            array("state"=>"Rhode Island","city"=>"Newport","place"=>"Middletown","url"=>"http://building-zoning.middletownri.com/"),
            array("state"=>"Rhode Island","city"=>"Newport","place"=>"Newport","url"=>"http://www.cityofnewport.com/departments/zoning-inspections"),
            array("state"=>"Rhode Island","city"=>"Newport","place"=>"Portsmouth","url"=>"https://www.portsmouthri.com/138/Building-Inspection"),
            array("state"=>"Rhode Island","city"=>"Newport","place"=>"Tiverton","url"=>"http://www.tiverton.ri.gov/departments/codeenforcement/index.php"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Burrillville","url"=>"https://www.burrillville.org/departments"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Central Falls","url"=>"http://www.centralfallsri.us/code_enforcement"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Cranston","url"=>"https://www.cranstonri.com/generalpage.php?page=18"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Cumberland","url"=>"https://www.cumberlandri.org/building-zoning"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"East Providence","url"=>"http://www.eastprovidence.com/content/9457/default.aspx"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Foster","url"=>"https://www.townoffoster.com/building-zoning"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Glocester","url"=>"http://www.glocesterri.org/building-zoning-department.htm"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Johnston","url"=>"https://www.townofjohnstonri.com/"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Lincoln","url"=>"http://www.lincolnri.org/departments/list/building.php#mobiletarget"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"North Providence","url"=>"https://northprovidenceri.gov/departments/"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"North Smithfield","url"=>"https://www.nsmithfieldri.org/building-inspection-zoning"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Pawtucket","url"=>"http://www.pawtucketri.com/"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Providence","url"=>"http://www.providenceri.gov/inspection-standards/"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Scituate","url"=>"http://www.scituateri.org/"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Smithfield","url"=>"https://www.smithfieldri.com/departments/"),
            array("state"=>"Rhode Island","city"=>"Providence","place"=>"Woonsocket","url"=>"https://www.woonsocketri.org/departments"),
            array("state"=>"Rhode Island","city"=>"Washington","place"=>"Charlestown","url"=>"https://www.charlestownri.org/index.asp?SEC=07FB203F-4F07-4E75-A974-76F4FC21DB61"),
            array("state"=>"Rhode Island","city"=>"Washington","place"=>"Exeter","url"=>"https://www.town.exeter.ri.us/building-department.html"),
            array("state"=>"Rhode Island","city"=>"Washington","place"=>"Hopkinton","url"=>"http://www.hopkintonri.org/departments/"),
            array("state"=>"Rhode Island","city"=>"Washington","place"=>"Narragansett","url"=>"https://www.narragansettri.gov/79/Building-Inspection"),
            array("state"=>"Rhode Island","city"=>"Washington","place"=>"North Kingstown","url"=>"https://www.northkingstown.org/"),
            array("state"=>"Rhode Island","city"=>"Washington","place"=>"Richmond","url"=>"https://www.richmondri.com/125/Building-Planning-Zoning"),
            array("state"=>"Rhode Island","city"=>"Washington","place"=>"South Kingstown","url"=>"https://www.southkingstownri.com/862/Permits-Inspections"),
            array("state"=>"Rhode Island","city"=>"Washington","place"=>"Westerly","url"=>"https://westerlyri.gov/152/Building-Office"),
        );
        return $data_array;
    }
    var $miami_country= array("number_1","number_2","number_3","number_4","number_5","number_6","number_7","number_8","number_9","number_10",
                                "number_11","number_12","number_13","number_14","number_15","number_16","number_17","number_18","number_19",
                                "number_20","number_21","number_22","number_23","number_24","number_25","number_26");

    var $broward_country=array("number_41","number_42","number_43","number_44","number_45","number_46","number_47","number_48","number_49","number_50",
    "number_51","number_52","number_53","number_54","number_55","number_56","number_57","number_58","number_59",
    "number_60","number_61","number_62","number_63","number_64","number_65","number_66","number_67","number_68","number_69");

    var $palm_beach_county=array("number_81","number_82","number_83","number_84","number_85","number_86","number_87","number_88","number_89","number_90",
    "number_91","number_92","number_93","number_94","number_95","number_96","number_97","number_98","number_99","number_100",
    "number_101","number_102","number_103","number_104","number_105","number_106","number_107","number_108","number_109","number_110",
    "number_111","number_112","number_113","number_114","number_115","number_116","number_117");

    var $Monroe_County=array("number_120","number_121","number_122","number_123","number_124");

    const number_1="Aventura";
    const number_2="Coral Gables";
    const number_3="City of Miami";
    const number_4="Doral";
    const number_5="Florida City";
    const number_6="Hialeah";
    const number_7="Hialeah Gardens";
    const number_8="Homestead";
    const number_9="Miami-Dade";
    const number_10="Miami Beach";
    const number_11="Miami Gardens";
    const number_12="Miami Springs";
    const number_13="North Bay Village";
    const number_14="North Miami";
    const number_15="North Miami Beach";
    const number_16="Opa-locka";
    const number_17="South Miami";
    const number_18="Sunny Isles Beach";
    const number_19="Sweetwater";
    const number_20="West Miami";
    const number_21="Pinecrest";
    const number_22="Surfside";
    const number_23="Miami Lakes";
    const number_24="Medlly";
    const number_25="Cutler Bay";
    const number_26="Key Biscayne";
    

    const number_41="Coconut Creek";
    const number_42="Cooper City";
    const number_43="Coral Springs";
    const number_44="Dania Beach";
    const number_45="Davie";
    const number_46="Deerfield Beach";
    const number_47="Fort Lauderdale";
    const number_48="Hallandale Beach";
    const number_49="Hillsboro Beach";
    const number_50="Hollywood";
    const number_51="Lauderdale-by-the-Sea";
    const number_52="Lauderdale Lakes";
    const number_53="Lauderhill";
    const number_54="Lighthouse Point";
    const number_55="Margate";
    const number_56="Miramar";
    const number_57="North Lauderdale";
    const number_58="Oakland Park";
    const number_59="Parkland";
    const number_60="Pembroke Park";
    const number_61="Pembroke Pines";
    const number_62="Plantation";
    const number_63="Pompano Beach";
    const number_64="Southwest Ranches";
    const number_65="Sunrise";
    const number_66="Tamarac";
    const number_67="West Park";
    const number_68="Weston";
    const number_69="Wilton Manors";
    


    const number_81="Atlantis";
    const number_82="Belle Glade";
    const number_83="Boca Raton";
    const number_84="Boynton Beach";
    const number_85="Briny Breezes";
    const number_86="Delray Beach";
    const number_87="Golf";
    const number_88="Greenacres";
    const number_89="Gulf Stream";
    const number_90="Haverhill";
    const number_91="Highland Beach";
    const number_92="Hypoluxo";
    const number_93="Juno Beach";
    const number_94="Jupiter";
    const number_95="Jupiter Inlet Colony";
    const number_96="Lake Clarke Shores";
    const number_97="Lake Park";
    const number_98="Lake Worth";
    const number_99="Lantana";
    const number_100="Loxahatchee Groves";
    const number_101="Manalapan";
    const number_102="Mangonia Park";
    const number_103="North Palm Beach";
    const number_104="Ocean Ridge";
    const number_105="Pahokee";
    const number_106="Palm Beach";
    const number_107="Palm Beach Gardens";
    const number_108="Palm Beach Shores";
    const number_109="Palm Springs";
    const number_110="Riviera Beach";
    const number_111="Royal Palm Beach";
    const number_112="South Bay";
    const number_113="South Palm Beach";
    const number_114="Tequesta";
    const number_115="Wellington";
    const number_116="Westlake";
    const number_117="West Palm Beach";



    const number_120="Key West";
    const number_121="Marathon";
    const number_122="Key Colony Beach";
    const number_123="Layton";
    const number_124="Key Largo";






    public function getArrayOptions($city){
        switch ($city) {
            case "Miami-Dade County":
                return $this->miami_country;
                break;
            case "Broward County":
                return $this->broward_country;
                break;
            case "Palm Beach County":
                return $this->palm_beach_county;
                break;
            case "Monroe County":
                return $this->Monroe_County;
                break;
            default:
                return "";
                break;
        }
        
        
    }




    public function number_1(){
        return "https://www.cityofaventura.com/169/Building-Permits";
    }

    public function number_2(){
        return "https://www.coralgables.com/departments/DevelopmentServices/building-division";
    }
    public function number_3(){
        return "http://www.miamigov.com/Building/";
    }
    public function number_4(){
        return "https://www.cityofdoral.com/all-departments/building/permit-information/";
    }
    public function number_5(){
        return "http://www.floridacityfl.gov/";
    }
    public function number_6(){
        return "http://www.hialeahfl.gov/154/Building";
    }
    public function number_7(){
        return "http://www.cityofhialeahgardens.com/cohg2/";
    }
    public function number_8(){
        return "https://www.cityofhomestead.com/148/Building-Permits";
    }
    public function number_9(){
        return "http://www.miamidade.gov/permits/";
    }
    public function number_10(){
        return "https://www.miamibeachfl.gov/city-hall/building/";
    }

    public function number_11(){
        return "https://www.miamigardens-fl.gov/";
    }
    public function number_12(){
        return "https://www.miamisprings-fl.gov/building";
    }
    public function number_13(){
        return "https://www.nbvillage.com/";
    }
    public function number_14(){
        return "http://www.northmiamifl.gov/northmiamifl/departments/building/";
    }
    public function number_15(){
        return "https://www.citynmb.com/149/Building-Division";
    }
    public function number_16(){
        return "http://www.opalockafl.gov/index.aspx?nid=73";
    }
    public function number_17(){
        return "https://www.southmiamifl.gov/244/Permits-Inspections";
    }
    public function number_18(){
        return "https://www.sibfl.net/building-dept/";
    }
    public function number_19(){
        return "http://www.cityofsweetwater.fl.gov/building-zoning.html";
    }
    public function number_20(){
        return "https://cityofwestmiamifl.com/index.asp?SEC=FC973A77-51B1-4B37-9C4C-01F340DE723D&Type=B_BASIC";
    }
    public function number_21(){
        return "https://www.pinecrest-fl.gov/government/building-planning";
    }
    public function number_22(){
        return "https://www.townofsurfsidefl.gov/departments-services/building";
    }
    public function number_23(){
        return "https://www.miamilakes-fl.gov/index.php?option=com_content&view=article&id=7&Itemid=138";
    }
    public function number_24(){
        return "http://www.townofmedley.com/building-and-zoning-department";
    }
    public function number_25(){
        return "http://cutlerbay-fl.gov/departments/community-development/building-";
    }
    public function number_26(){
        return "http://keybiscayne.fl.gov/index.php?submenu=_building&src=gendocs&ref=BuildingZoningPlanning&category=Depts";
    }


    public function number_41(){
        return "https://www.coconutcreek.net/sd/building-department";
    }
    public function number_42(){
        return "https://www.coopercityfl.org/";
    }
    public function number_43(){
        return "https://www.coralsprings.org/government/other-departments-and-services/building";
    }
    public function number_44(){
        return "https://daniabeachfl.gov/125/Building-Division";
    }
    public function number_45(){
        return "https://www.davie-fl.gov/206/Building";
    }
    public function number_46(){
        return "https://www.deerfield-beach.com/294/Building-Services";
    }
    public function number_47(){
        return "https://www.fortlauderdale.gov/departments/sustainable-development/building-services";
    }
    public function number_48(){
        return "https://hallandalebeachfl.gov/1031/Forms";
    }
    public function number_49(){
        return "https://www.townofhillsborobeach.com/196/Building-Department";
    }
    public function number_50(){
        return "https://www.hollywoodfl.org/328/Building";
    }
    public function number_51(){
        return "http://www.lauderdalebythesea-fl.gov/dev/buildingpage.htm";
    }
    public function number_52(){
        return "https://www.lauderdalelakes.org/160/Building";
    }
    public function number_53(){
        return "https://www.lauderhill-fl.gov/departments";
    }
    public function number_54(){
        return "https://city.lighthousepoint.com/building-and-zoning/";
    }
    public function number_55(){
        return "https://www.margatefl.com/196/Building";
    }
    public function number_56(){
        return "https://www.miramarfl.gov/150/Building-Permits-Inspections";
    }
    public function number_57(){
        return "http://www.nlauderdale.org/departments/community_development/index.php";
    }
    public function number_58(){
        return "https://oaklandparkfl.gov/172/Building-Permit-Applications-Forms";
    }
    public function number_59(){
        return "http://www.townofpembrokepark.com/departments/building-department-applications-forms/";
    }
    public function number_60(){
        return "https://www.ppines.com/164/Building-Department";
    }
    public function number_61(){
        return "http://www.plantation.org/Building/";
    }
    public function number_62(){
        return "http://pompanobeachfl.gov/pages/dev_scv_building_inspections/building_inspections";
    }
    public function number_63(){
        return "http://www.southwestranches.org/departments/building-permits/";
    }
    public function number_64(){
        return "https://www.sunrisefl.gov/index.aspx?page=97";
    }
    public function number_65(){
        return "https://www.tamarac.org/134/Permits-Inspections";
    }
    public function number_66(){
        return "https://web.cityofwestpark.net/departments-2/building-department";
    }
    public function number_67(){
        return "https://www.westonfl.org/government/building-code-and-permitting-services";
    }
    public function number_68(){
        return "https://www.wiltonmanors.com/133/Building-Permit-Applications";
    }
    public function number_69(){
        return "https://www.cityofaventura.com/169/Building-Permits";
    }

    


    public function number_81(){
        return "https://www.atlantisfl.gov/building-department/pages/building-department-forms";
    }
    public function number_82(){
    return "http://www.bellegladegov.com/index.php?option=com_content&view=article&id=92&Itemid=78";
    }
    public function number_83(){
    return "https://www.myboca.us/1186/Licensing-Permitting";
    }
    public function number_84(){
    return "https://www.boynton-beach.org/permits";
    }
    public function number_85(){
    return "http://townofbrinybreezes-fl.com/licenses_permits_fees/licenses_permits_fees.htm";
    }
    public function number_86(){
    return "http://www.mydelraybeach.com/departments/community_improvement/building_codes_and_ordinances.php";
    }
    public function number_87(){
    return "http://www.villageofgolf.org/major-construction";
    }
    public function number_88(){
    return "https://greenacresfl.gov/building";
    }
    public function number_89(){
    return "https://www.gulf-stream.org/";
    }
    public function number_90(){
    return "https://www.townofhaverhill-fl.gov/building";
    }
    public function number_91(){
    return "https://highlandbeach.us/departments/building-department/";
    }
    public function number_92(){
    return "http://www.hypoluxo.org/256541.html";
    }
    public function number_93(){
    return "https://www.juno-beach.fl.us/";
    }
    public function number_94(){
    return "https://www.jupiter.fl.us/93/Building";
    }
    public function number_95(){
    return "http://www.jupiterinletcolony.org/building-department.html";
    }
    public function number_96(){
    return "http://www.townoflakeclarkeshores.com/service/permits-and-licenses";
    }
    public function number_97(){
    return "https://www.lakeparkflorida.gov/cdd";
    }
    public function number_98(){
    return "https://www.lakeworth.org/business/permits/";
    }
    public function number_99(){
    return "https://www.lantana.org/building-permits";
    }
    public function number_100(){
    return "http://www.loxahatcheegrovesfl.gov/forms";
    }
    public function number_101(){
    return "https://www.manalapan.org/index.aspx?nid=478";
    }
    public function number_102(){
    return "http://www.townofmangoniapark.com/departments/buildingplanningzoning.html";
    }
    public function number_103(){
    return "https://www.village-npb.org/149/Building-Division";
    }
    public function number_104(){
    return "http://www.oceanridgeflorida.com/";
    }
    public function number_105(){
    return "http://www.cityofpahokee.com/Pages/PahokeeFL_Building/index";
    }
    public function number_106(){
    return "https://www.townofpalmbeach.com/284/Planning-Zoning-Building";
    }
    public function number_107(){
    return "https://www.pbgfl.com/159/Planning-Zoning";
    }
    public function number_108(){
    return "http://www.palmbeachshoresfl.us/departments/building_department/index.php";
    }
    public function number_109(){
    return "https://vpsfl.org/index.aspx?NID=288";
    }
    public function number_110(){
    return "http://www.rivierabch.com/content/24503/24519/default.aspx";
    }
    public function number_111(){
    return "https://www.royalpalmbeach.com/index.aspx?NID=84";
    }
    public function number_112(){
    return "http://www.southbaycity.com/Public_Documents/index";
    }
    public function number_113(){
    return "http://www.southpalmbeach.com/247261.html";
    }
    public function number_114(){
    return "https://www.tequesta.org/1204/Building-Department";
    }
    public function number_115(){
    return "https://www.wellingtonfl.gov/government/departments/planning-zoning";
    }
    public function number_116(){
    return "https://www.westlakegov.com/";
    }
    public function number_117(){
    return "http://wpb.org/Departments/Development-Services/Construction/Overview";
    }












    public function number_120(){
    return "https://www.cityofkeywest-fl.gov/department/index.php?structureid=1";
    }
    public function number_121(){
    return "http://www.ci.marathon.fl.us/government/departments/building/";
    }
    public function number_122(){
    return "https://keycolonybeach.net/";
    }
    public function number_123(){
    return "http://www.laytoncity.org/LC/CD/BuildingDivision";
    }
    public function number_124(){
    return "https://www.monroecounty-fl.gov/149/Building";
    }









}

?>