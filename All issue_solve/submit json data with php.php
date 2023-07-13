<!DOCTYPE html>
<html>
<body>


<?php

function parseSections($data)
{
    $sections = [];

    foreach ($data as $key => $value) {
    	if (strpos($key, 'section_form_count_') === 0) {
            $sectionNumber = intval($value);
            
            $sectionNameKey = 'section_name_' . $sectionNumber;
            
            $sectionName = isset($data[$sectionNameKey]) ? $data[$sectionNameKey] : '';

            if (!isset($sections[$sectionNumber])) {
                $sections[$sectionNumber] = [
                    'section' => $sectionNumber,
                    'section_name' => $sectionName,
                    'items' => []
                ];
            }
       	}
        if (strpos($key, 'section_'.$sectionNumber.'_item_form_count_') === 0) {
            $item_number = intval($value);
            
           if ($item_number !== null) {
                $item = [
                    'item' => $item_number,
                    'title' => $data['section_'.$sectionNumber.'_item_title_' . $item_number],
                    'sub_title' => $data['section_'.$sectionNumber.'_item_sub_title_' . $item_number],
                    'image' => $data['section_'.$sectionNumber.'_item_image_' . $item_number],
                    'short_description' => $data['section_'.$sectionNumber. '_item_short_description_' . $item_number],
                    'description' => $data['section_'.$sectionNumber.'_item_description_' . $item_number]
                ];

                $sections[$sectionNumber]['items'][] = $item;
            }
        }
	}
    return $sections;
}

// Example usage
$data = [
    "section_form_count_0" => "0",
    "section_0" => "0",
    "section_name_0" => "title",
    "design_name_0" => "default",
    "section_0_item_form_count_0" => "0",
    "section_0_item_0" => "0",
    "section_0_item_title_0" => "title_0",
    "section_0_item_sub_title_0" => "sub_title_0",
    "section_0_item_image_0" => "image_0",
    "section_0_item_short_description_0" => "short_description_0",
    "section_0_item_description_0" => "description_0",
    "section_0_item_form_count_2" => "2",
    "section_0_item_2" => "2",
    "section_0_item_title_2" => "title",
    "section_0_item_sub_title_2" => "sub_title",
    "section_0_item_image_2" => "image",
    "section_0_item_short_description_2" => "short_description",
    "section_0_item_description_2" => "description",
    "section_0_item_form_count_4" => "4",
    "section_0_item_4" => "4",
    "section_0_item_title_4" => "title",
    "section_0_item_sub_title_4" => "sub_title",
    "section_0_item_image_4" => "image",
    "section_0_item_short_description_4" => "short_description",
    "section_0_item_description_4" => "description",
    "section_form_count_1" => "1",
    "section_1" => "1",
    "section_name_1" => "title",
    "design_name_1" => "default",
    "section_1_item_form_count_1" => "1",
    "section_1_item_1" => "1",
    "section_1_item_title_1" => "title",
    "section_1_item_sub_title_1" => "sub_title",
    "section_1_item_image_1" => "image",
    "section_1_item_short_description_1" => "short_description",
    "section_1_item_description_1" => "description",
    "section_1_item_form_count_2" => "2",
    "section_1_item_2" => "2",
    "section_1_item_title_2" => "title",
    "section_1_item_sub_title_2" => "sub_title",
    "section_1_item_image_2" => "image",
    "section_1_item_short_description_2" => "short_description",
    "section_1_item_description_2" => "description",
    "section_form_count_2" => "2",
    "section_2" => "2",
    "section_name_2" => "title",
    "design_name_2" => "default",
    "section_form_count_3" => "3",
    "section_3" => "3",
    "section_name_3" => "title",
    "design_name_3" => "default",
    "section_3_item_form_count_0" => "0",
    "section_3_item_0" => "0",
    "section_3_item_title_0" => "title",
    "section_3_item_sub_title_0" => "sub_title",
    "section_3_item_image_0" => "image",
    "section_3_item_short_description_0" => "short_description",
    "section_3_item_description_0" => "description"
];

$sections = parseSections($data);
echo '<pre>';
print_r($sections);
echo '</pre>';
?>



</body>
</html>
