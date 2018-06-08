<?php
echo phpinfo();
$symbols = array(";", "/", ",");
$input = array("a", "4/g", "b", " ", ",", "c",
    array(1, 2, 3, "si", "*',"), "d", "e", 1, "“", "1", 2, "2", "3", "3", 5, 3.5, "2,5", "ab,5", "ba;4", 0);
$input = expand($input);
$input = separate($input);
$output = groupByType($input);
var_dump($output);

#funktsioon, mis teeb uue expanded array, mille sisse pannakse k6ik yksikelemendid ja kuhu merge-takse ka elemendid, mis on arrayd.
#siis returnitakse kogu see uus tekkinud array
function expand($array)
{
    $expanded = array();

    foreach ($array as $element) {
        $expanded = array_merge_recursive($expanded, (array) $element);
    }

    return $expanded;
}

#funktsioon, mis vaatab, kas iga array elemendi sees on teatud symbol, kui on, siis ta explodeb symboli ja merge-b tekkinud array
# vana arrayga. samuti tekitab uue array exclude, millesse paneb originaalsed elemendid, milles leidus symbol.
#l6pus returnib exclude ja result array erinevused (ehk result arrayst eemaldatakse originaal elemendid)
function separate($array)
{
    $result = $array;
    $symbols = $GLOBALS['symbols'];
    $exclude = array();

    foreach ($symbols as $symbol) {
        foreach ($array as $element) {
            if (strpos($element, $symbol) !== false) {
                $result = array_merge($result, explode($symbol, $element));
                $exclude[] = $element;
            }
        }
    }

    return array_diff($result, $exclude);
}

#funcktsioon, mis v6tab iga value, v6tab selle type-i, tsekib, kas sellest type-st key juba eksisteerib arrays output
# mis on uus array, kus saab sorteeritud array olema. kui key eksisteerib, siis pushitakse element arraysse type key valueks.
# false puhul lisatakse output array key(mis on elemndi type) valueks element.
function groupByType($array)
{
    $output = array();
    foreach ($array as $element) {
        $type = gettype($element);
        if (array_key_exists($type, $output)) {
            $output[$type] = (array) $output[$type];
            array_push($output[$type], $element);
        } else {
            $output[$type] = $element;
        }
    }
    return $output;
}
