<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use Config\Services;

class CategoryController extends BaseController
{
    protected $categoryModel;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();

        if (session()->get('level') != "admin") {
            echo 'Access denied';
            exit;
        }
    }

    public function index()
    {
        $categories = $this->categoryModel->findAll();
        $data = [
            'page' => 'category',
            'categories' => $categories
        ];

        return view('layouts/pages/admin/category/index', $data);
    }

    public function create()
    {
        helper(['form']);
        $data = [
            'page' => 'category',
            'validation' => Services::validation(),
        ];

        echo view('layouts/pages/admin/category/create', $data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'name' => 'required|min_length[1]|is_unique[categories.name]',
        ];

        if ($this->validate($rules)) {
            $data = [
                'name' => $this->request->getVar('name'),
                'slug' => url_title($this->request->getVar('name'), '-', TRUE),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->categoryModel->save($data);
            session()->setFlashdata('success_category', 'Create Category successfully.');
            return redirect()->to("/admin/category");
        } else {
            $validation = Services::validation();
            return redirect()->to('/admin/category/form')->withInput()->with('validation', $validation);
        }
    }

    public function detail($id)
    {
        helper(['form']);
        $data = [
            'page' => 'category',
            'validation' => Services::validation(),
            'category' => $this->categoryModel->where(['categoryId' => $id])->first(),
        ];

        echo view('layouts/pages/admin/category/detail', $data);
    }

    public function edit($id)
    {
        helper(['form']);
        $data = [
            'page' => 'category',
            'validation' => Services::validation(),
            'category' => $this->categoryModel->where(['categoryId' => $id])->first(),
        ];

        echo view('layouts/pages/admin/category/edit', $data);
    }

    public function update($id)
    {
        helper(['form']);
        $rules = [
            'name' => 'required|min_length[1]',
        ];

        if ($this->validate($rules)) {
            $data = [
                'categoryId' => $id,
                'name' => $this->request->getVar('name'),
                'slug' => url_title($this->request->getVar('name'), '-', TRUE),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->categoryModel->replace($data);
            session()->setFlashdata('success_category', 'Update Category successfully.');
            return redirect()->to("/admin/category");
        } else {
            $validation = Services::validation();
            return redirect()->to('/admin/category/edit/' . $id)->withInput()->with('validation', $validation);
        }
    }

    public function delete($id)
    {
        $this->categoryModel->where(['categoryId' => $id])->delete();
        session()->setFlashdata('success_category', 'Delete Category successfully.');
        return redirect()->to('/admin/category');
    }
}
