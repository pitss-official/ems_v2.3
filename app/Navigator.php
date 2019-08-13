<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Navigator extends Model
{
    //
    protected $table = 'user_navigation';

    /*
     * This function will fetch the links for the user and put them in the interface through api (axios)
     */
    private $flag=0,$last;
    private function showNavTitle($find)
    {
        $heads =(array)DB::table('user_navigation_titles')
            //TODO: Find should be protected from sql injection
            ->where('id','=',$find)->get()[0];
        if($this->flag!=0)
        {
            return '<li class="nav-devider"></li><li class="nav-small-cap">'.$heads['title'].'</li>';
        }else
        {
            $this->flag=1;
            return '<li class="nav-small-cap">'.$heads['title'].'</li>';
        }
    }
    public function getNavigationLinks(int $userLevel,int $parent_id=0)
    {
        $menu = "";
        $dash=[];

        $rows = DB::table('user_navigation')
            ->where([['status',1],['parent_id',$parent_id],['level','<=',$userLevel]])
            //todo: @PRIORITY:HIGH menu_id and title are vulnerable to sql injection, correction is required
            ->orderByRaw('menu_id, title ASC ')->get();
        foreach($rows as $row)
        {
            $row=(array)$row;
            $count = DB::table('user_navigation')
                ->where([['status',1],['parent_id',$parent_id],['level','<=',$userLevel]])
                ->count();
            if($row['parent_id']==0 and $row['link']=="#" and $count==0)
            {
                continue;
            }
            if($row['title']!=-1)
            {
                if(array_search($this->showNavTitle($row['title']),$dash)==false)
                {
                    array_push($dash,$this->showNavTitle($row['title']));
                    $menu.=$this->showNavTitle($row['title']);
                }

            }
            $tag="a";
            $href="href";
            if($row['link']=="#")
                $inc='class="has-arrow waves-effect waves-dark"';
            else {$inc="";$tag="router-link";$href="to";}
            $spn="";
            $ifSpn=0;
            if($row['parent_id']==0)
            {
                $spn='<span class="hide-menu">';
                $ifSpn=1;
            }
            $menu .="<li><$tag $inc $href='".$row['link']."'>";
            if(isset($row['icon']))
                $menu.='<i class="mdi mdi-'.$row['icon'].'"></i>';
            if($ifSpn)$menu.=$spn;
            if($ifSpn)$menu.='</span>';
            $menu.=$row['menu_name']."</$tag>";
            $sub=$this->getNavigationLinks($userLevel,$row['menu_id']);
            if ($sub!="")
            {
                $menu .= "<ul aria-expanded='false' class='collapse'>".$sub."</ul>"; //call  recursively
            }
            $menu .= "</li>";
            $this->last=0;
        }
        return $menu;
    }

}
