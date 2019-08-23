<?php

namespace Modules\Itrivia\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterItriviaSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        //$sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('itrivia::itriviazes.title.itriviazes'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('itrivia::trivias.title.trivias'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.itrivia.trivia.create');
                    $item->route('admin.itrivia.trivia.index');
                    $item->authorize(
                        $this->auth->hasAccess('itrivia.trivias.index')
                    );
                });
                $item->item(trans('itrivia::questions.title.questions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.itrivia.question.create');
                    $item->route('admin.itrivia.question.index');
                    $item->authorize(
                        $this->auth->hasAccess('itrivia.questions.index')
                    );
                });
                $item->item(trans('itrivia::answers.title.answers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.itrivia.answer.create');
                    $item->route('admin.itrivia.answer.index');
                    $item->authorize(
                        $this->auth->hasAccess('itrivia.answers.index')
                    );
                });
                $item->item(trans('itrivia::userquestionanswers.title.userquestionanswers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.itrivia.userquestionanswer.create');
                    $item->route('admin.itrivia.userquestionanswer.index');
                    $item->authorize(
                        $this->auth->hasAccess('itrivia.userquestionanswers.index')
                    );
                });
                $item->item(trans('itrivia::usertrivias.title.usertrivias'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.itrivia.usertrivia.create');
                    $item->route('admin.itrivia.usertrivia.index');
                    $item->authorize(
                        $this->auth->hasAccess('itrivia.usertrivias.index')
                    );
                });
                $item->item(trans('itrivia::rangepoints.title.rangepoints'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.itrivia.rangepoint.create');
                    $item->route('admin.itrivia.rangepoint.index');
                    $item->authorize(
                        $this->auth->hasAccess('itrivia.rangepoints.index')
                    );
                });
// append






            });
        });

        return $menu;
    }
}
