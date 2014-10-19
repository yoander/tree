<?php

$path = __DIR__ . '/db';
$ajax = false;

require_once __DIR__ . '/src/YVR/Util/Observer.php';
require_once __DIR__ . '/src/YVR/Util/Subject.php';
require_once __DIR__ . '/src/YVR/Util/NodeObserver.php';
require_once __DIR__ . '/src/YVR/Util/SingletonTrait.php';
require_once __DIR__ . '/src/YVR/Util/Registry.php';
require_once __DIR__ . '/src/YVR/Util/NodeRegistry.php';
require_once __DIR__ . '/src/YVR/Util/SlugPathMapper.php';
require_once __DIR__ . '/src/YVR/Util/ChangeManager.php';
require_once __DIR__ . '/src/YVR/Util/Slugify.php';
require_once __DIR__ . '/src/YVR/Tree/Node.php';
require_once __DIR__ . '/src/YVR/Tree/Tree.php';
require_once __DIR__ . '/src/YVR/Util/PersistentStorageInterface.php';
require_once __DIR__ . '/src/YVR/Util/FileStorage.php';

require_once __DIR__ . '/src/YVR/Helper/HtmlHelper.php';

//require '/www/kint/Kint.class.php';

use YVR\Tree\Tree as Tree;
use YVR\Tree\Index as Index;
use YVR\Helper\HtmlHelper as HtmlHelper;
use YVR\Util\Session as Session;
use YVR\Util\SlugPathMapper as SlugPathMapper;
use YVR\Util\FileStorage;


$file = sys_get_temp_dir() . '/tree.txt';
$fs = new FileStorage($file);

$slug = !empty($_REQUEST['slug']) ? $_REQUEST['slug']: null;

$slugPathMapper = [];

if (!empty($slug)) {
    $ajax = true;
    $slugPathMapper = $fs->get();
    $path = isset($slugPathMapper[$slug]) ? $slugPathMapper[$slug] : '';
}

$tree = (new Tree($path))->recursive(false)->get();

$slugPathMapper += SlugPathMapper::instance()->getArray();

$fs->setData($slugPathMapper)->save();

$output = HtmlHelper::printTree($tree, YVR\Util\SlugPathMapper::instance()->getArray());

if ($ajax)
    echo $output;
else {
?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Tree</title>
            <link href="css/vendor/bootstrap.min.css" rel="stylesheet">
            <link href="css/main.css" rel="stylesheet">
        </head>
        <body>
            <?php echo $output ?>
            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="js/vendor/jquery.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="js/vendor/amplify.store.min.js"></script>
            <script src="js/main-nonrecursive.js"></script>
        </body>
    </html>
<?php } ?>
