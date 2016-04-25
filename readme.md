# PhpTokenizer
is a class that i wrote before,i didn't known the token_get_all() function at that time.thus i re-made the wheel.

# simple usage

```php
<?php
// filename: /test/test.php
$path_to_rongFramework = __DIR__ . "/../";
set_include_path( get_include_path() .PATH_SEPARATOR . $path_to_rongFramework );

require_once __DIR__ . '/../PhpTokenizer.php';

$cnt = file_get_contents( __DIR__ . "/test_src.php" );

$pt = new PhpTokenizer();
$result = $pt->tokenize($cnt);
print_r( $result);

```

### output
```php
Array
(
    [data] => Array
        (
            [0] => <?php
            [1] =>
$name
            [2] => =
            [3] => "Yang Qing-rong"
            [4] => ;
            [5] =>
$text
            [6] => =
            [7] => "the \"wudimei\" is Yang's website."
            [8] => ;
            [9] =>
$age
            [10] => =
            [11] =>  32
            [12] => ;
            [13] =>
class
            [14] =>  Person
            [15] => {
            [16] => 	public
            [17] =>  $name
            [18] => ;
            [19] => 	public
            [20] =>  $age
            [21] => ;
            [22] => 	public
            [23] =>  function
            [24] =>  __construct
            [25] => (
            [26] => $name
            [27] => ,
            [28] => $age
            [29] => )
            [30] => {
            [31] => 	$this
            [32] => ->
            [33] => name
            [34] => =
            [35] =>  $name
            [36] => ;
            [37] => 	$this
            [38] => ->
            [39] => age
            [40] => =
            [41] =>  $age
            [42] => ;
            [43] => }
            [44] => 	public
            [45] =>  function
            [46] =>  setName
            [47] => (
            [48] =>  $name
            [49] => )
            [50] => {
            [51] => 	$this
            [52] => ->
            [53] => name
            [54] => =
            [55] =>  $name
            [56] => ;
            [57] => }
            [58] => 	public
            [59] =>  function
            [60] =>  getName
            [61] => (
            [62] => )
            [63] => {
            [64] => 	return
            [65] =>  $this
            [66] => ->
            [67] => name
            [68] => ;
            [69] => }
            [70] => }
            [71] =>
$p
            [72] => =
            [73] =>  new
            [74] =>  Person
            [75] => (
            [76] => $name
            [77] => ,
            [78] => $age
            [79] => )
            [80] => ;
            [81] =>
echo
            [82] =>  $p
            [83] => ->
            [84] => getName
            [85] => (
            [86] => )
            [87] => ;
            [88] => ?>
            [89] => <?php
            [90] =>
$i
            [91] => =
            [92] => 0
            [93] => ;
            [94] =>
$i
            [95] => ++
            [96] => ;
            [97] =>
while
            [98] => (
            [99] =>  $i
            [100] => <
            [101] => 10
            [102] => )
            [103] => {
            [104] => 	$i
            [105] => ++
            [106] => ;
            [107] => }
            [108] =>
if
            [109] => (
            [110] =>  $i
            [111] => >=
            [112] => 10
            [113] => )
            [114] => {
            [115] => 	echo
            [116] => "gt 10<br />"
            [117] => ;
            [118] => }
            [119] =>
for
            [120] => (
            [121] =>  $i
            [122] => =
            [123] => 0
            [124] => ;
            [125] => $i
            [126] => <
            [127] => 3
            [128] => ;
            [129] => $i
            [130] => ++
            [131] => )
            [132] => {
            [133] => 	echo
            [134] =>  $i
            [135] => ;
            [136] => }
            [137] => ?>
        )

    [length] => 138
)

```
