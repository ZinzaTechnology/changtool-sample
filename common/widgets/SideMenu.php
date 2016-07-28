<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\widgets;

use Yii;
use yii\widgets\Menu;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * This class customizes yii\widgets\Menu
 * to conform certain needs
 */
class SideMenu extends Menu
{
    public $items = [];
    public $customTemplateOptions = [];
    public $linkTemplate = '<a href="{url}">{labelTpl}</a>';
    public $labelTemplate = '<i class="fa {icon}"></i> <span class="nav-label">{label}</span>';

    /**
     * @override
     *
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     * @return string the rendering result
     */
    protected function renderItem($item)
    {
        $linkTemplate = '';
        if (isset($item['url'])) {
            $linkTemplate = ArrayHelper::getValue($item, 'linkTemplate', $this->linkTemplate);
            $labelTemplate = ArrayHelper::getValue($item, 'labelTemplate', $this->labelTemplate);

            $linkTemplate = strtr($linkTemplate, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{labelTpl}' => $labelTemplate,
            ]);
        } else {
            $linkTemplate = ArrayHelper::getValue($item, 'labelTemplate', $this->labelTemplate);
        }

        // default replacements is `label`
        $replacements = [
            '{label}' => $item['label'],
        ];
        
        // custom replacements
        $customTemplateOptions = $this->customTemplateOptions;
        foreach ($customTemplateOptions as $opt) {
            if (isset($item[$opt])) {
                $replacements["{{$opt}}"] = $item[$opt];
            }
        }
        return strtr($linkTemplate, $replacements);
    }

    /**
     * @override
     *
     * @param array $item the menu item to be checked
     * @return boolean whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = Yii::getAlias($item['url'][0]);
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (isset($item['controllers'])) {
                $target_controllers = $item['controllers'];
                $controller_id = Yii::$app->controller->id;
                if (array_key_exists($controller_id, $target_controllers)) {
                    $action_id = Yii::$app->controller->action->id;
                    if ($target_controllers[$controller_id] === '*' || in_array($action_id, $target_controllers)) {
                        return true;
                    }
                }
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }
}
