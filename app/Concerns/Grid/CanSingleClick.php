<?php

namespace App\Concerns\Grid;

use Encore\Admin\Admin;

trait CanSingleClick
{
    /**
     * Single-click grid row to jump to the edit page.
     *
     * @return $this
     */
    public function enableSingleClick(): static
    {
        $script = <<<SCRIPT
$('body').on('click', 'table#{$this->tableID}>tbody>tr', function(e) {
    var url = "{$this->resource()}/"+$(this).data('key')+"/edit";
    $.admin.redirect(url);
});
SCRIPT;
        Admin::script($script);

        return $this;
    }
}
