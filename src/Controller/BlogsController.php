<?php
declare(strict_types=1);

namespace App\Controller;

use Laminas\Diactoros\UploadedFile;

/**
 * Blogs Controller
 *
 * @property \App\Model\Table\BlogsTable $Blogs
 */
class BlogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Blogs->find();
        $blogs = $this->paginate($query);

        $this->set(compact('blogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Blog id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $blog = $this->Blogs->get($id, contain: []);
        $this->set(compact('blog'));
    }

    /**
    * upload method
    *
    * @return string|false
    */
    private function upload(UploadedFile $file)
    {
        if ($file->getError() || !str_contains($file->getClientMediaType(), "image")){
            $this->Flash->error(__('Format de fichier non valide !'));

            return false;
        }
        $dest = WWW_ROOT . 'img/upload/';
        if (!file_exists($dest)) {
            mkdir($dest, 0777, true);
        }
        $destFile = $dest . $file->getClientFilename();
        if (file_exists($destFile)) {
            $this->Flash->error(__('Ce fichier existe déjà.'));

            return false;
        }
        $file->moveTo($destFile);
        return $file->getClientFilename();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $blog = $this->Blogs->newEmptyEntity();
        if ($this->request->is('post')) {
            $upload = $this->upload($this->request->getData('picture'));
            if (!$upload) {
                return $this->redirect(['action' => 'index']);
            }
            $data = array_merge($this->request->getData(), ['picture' => $upload]);
            $blog = $this->Blogs->patchEntity($blog, $data);
            if ($this->Blogs->save($blog)) {
                $this->Flash->success(__('Votre article à été mis à jour.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Une erreur est survenue.'));
        }
        $this->set(compact('blog'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Blog id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $blog = $this->Blogs->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $blog = $this->Blogs->patchEntity($blog, $this->request->getData());
            if ($this->Blogs->save($blog)) {
                $this->Flash->success(__('Votre article à été mis à jour.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Une erreur est survenue.'));
        }
        $this->set(compact('blog'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Blog id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $blog = $this->Blogs->get($id);
        if ($this->Blogs->delete($blog)) {
            $this->Flash->success(__('Article supprimé.'));
        } else {
            $this->Flash->error(__('The blog could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
