<?php
/**
 * Page Speed Optimizer extension
 * https://www.mobilejoomla.com/
 *
 * @version    1.4.2
 * @license    GNU/GPL v2 - http://www.gnu.org/licenses/gpl-2.0.html
 * @copyright  (C) 2022-2024 Denis Ryabov
 * @date       June 2024
 */
defined('_JEXEC') or die('Restricted access');

/** @var MjController $this */
/** @var array $params */
/** @var string $controllerName */
/** @var string $viewName */

$form = $params['form'];

$controllerName = $params['controllerName'];
$viewName = $params['viewName'];
$settings = $params['settings'];

/** @var JApplicationAdministrator $app */
$app = MJFactory::getApplication();
$app->triggerEvent('onPsoDisplayConfig', array($controllerName . '/' . $viewName, &$form, &$settings));

$hidden = isset($params['options']) ? $params['options'] : array();

?>
<form method="post" action="index.php" id="adminForm" name="adminForm" enctype="multipart/form-data">
    <?php echo MJHtml::_('form.token'); ?>
    <input type="hidden" name="option" value="com_pso">
    <input type="hidden" name="task" value="save">
    <input type="hidden" name="controller" value="<?php echo $controllerName; ?>">
    <input type="hidden" name="view" value="<?php echo $viewName; ?>">
    <?php foreach ($hidden as $key => $value) : ?>
        <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
    <?php endforeach; ?>
    <div class="row g-4">
        <?php foreach ($form as $i => $column) : ?>
            <div class="col-md" id="mj-column-<?php echo (int)$i; ?>">
                <?php foreach ($column as $legend => $fields) : ?>
                    <?php if (count($fields)) : ?>
                        <div class="card mb-4">
                            <div class="card-header h4<?php
                            if (isset($fields['class'])) {
                                echo ' ' . $fields['class'];
                            }
                            ?>" role="button" data-bs-toggle="collapse" data-bs-target="#mj-<?php echo $legend; ?>"><?php
                                echo MJText::_($legend);
                                if (isset($fields['link'])) {
                                    ?><span class="float-end ms-auto me-n2 my-n2"><?php
                                    echo $fields['link'];
                                    ?></span><?php
                                }
                                ?></div>
                            <div id="mj-<?php echo $legend; ?>" class="show">
                                <div class="card-body p-0">
                                    <?php if (isset($fields['card'])) : ?>
                                        <?php echo $fields['card']; ?>
                                    <?php else : ?>
                                        <div class="list-group list-group-flush">
                                            <?php foreach ($fields as $key => $field) : ?>
                                                <?php if (is_numeric($key)) : ?>
                                                    <?php
                                                    $wrapClassSuffix = isset($field['wrapClass']) ? ' ' . $field['wrapClass'] : '';
                                                    $classSuffix = isset($field['class']) ? ' ' . $field['class'] : '';
                                                    $depends = isset($field['depends']) ?
                                                        ' data-mj-depends="' . htmlspecialchars($field['depends'], ENT_COMPAT) . '"' :
                                                        '';
                                                    ?>
                                                    <div class="list-group-item<?php echo $wrapClassSuffix; ?>"<?php echo $depends; ?>>
                                                        <div class="row g-3<?php echo $classSuffix; ?>">
                                                            <?php if (!isset($field['input'])) : /*label only*/ ?>
                                                                <?php echo $field['label']; ?>
                                                            <?php elseif (!isset($field['label'])) : /*input only*/ ?>
                                                                <div class="col-sm-8 offset-sm-4"><?php echo $field['input']; ?></div>
                                                            <?php else : /*both*/ ?>
                                                                <?php echo $field['label']; ?>
                                                                <div class="col-sm-8"><?php echo $field['input']; ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</form>