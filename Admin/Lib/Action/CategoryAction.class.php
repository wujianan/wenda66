<?php
/**
 * @desc Created by PhpStorm.
 * @author: 莫名私下里
 * @since: 2018/6/6 16:25
 *
 */
class CategoryAction extends CommonAction
{
    /**
     * 分类列表
     */
    public function index()
    {
        $cate = M('category')->select();
        $this->cate = recursive($cate);
        $this->display();
    }
    /**
     * 添加顶级分类
     */
    public function addTop()
    {
        $this->display();
    }

    /**
     *  添加子分类视图
     */
    public function addChild () {
        $this->cate = M('category')->find($this->_get('pid', 'intval'));
        $this->display();
    }
    /**
     *  添加分类表单处理
     */
    public function addCate () {
        if (M('category')->data($_POST)->add()) {
            $this->success('添加成功', 'index');
        } else {
            $this->error('添加失败');
        }
    }

    /**
     *  修改分类视图
     */
    public function edit () {
        $this->cate = M('category')->find($this->_get('id', 'intval'));
        $this->display();
    }

    /**
     *  修改分类操作
     */
    public function editCate () {
        if (M('category')->save($_POST)) {
            $this->success('修改成功', 'index');
        } else {
            $this->error('修改失败');
        }
    }
    /**
     *  删除分类
     */
    public function del () {
        $id = $this->_get('id', 'intval');
        $db = M('category');
        $cateid = $db->field(array('id', 'pid'))->select();
        $delid = get_all_child($cateid, $id);
        $delid[] = $id;

        $where = array('id' => array('IN', $delid));

        if (!$db->where($where)->delete()) {
            $this->error('删除失败');
        }

        $this->success('删除成功', U('index'));
    }
}