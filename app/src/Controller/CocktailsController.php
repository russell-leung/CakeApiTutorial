<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Cocktails Controller
 *
 * @property \App\Model\Table\CocktailsTable $Cocktails
 * @method \App\Model\Entity\Cocktail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CocktailsController extends AppController
{

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $cocktails = $this->Cocktails->find('all')->all();
        $this->set('cocktails', $cocktails);
        $this->viewBuilder()->setOption('serialize', ['cocktails']);

        $cocktails = $this->paginate($this->Cocktails);

        $this->set(compact('cocktails'));
    }

    /**
     * View method
     *
     * @param string|null $id Cocktail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $cocktail = $this->Cocktails->get($id);
        $this->set('cocktail', $cocktail);
        $this->viewBuilder()->setOption('serialize', ['cocktail']);

        $cocktail = $this->Cocktails->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('cocktail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $cocktail = $this->Cocktails->newEntity($this->request->getData());
            if ($this->Cocktails->save($cocktail)) {
                $message = 'Saved';
                $this->Flash->success(__('The cocktail has been saved.'));
            } else {
                $message = 'Error';
                $this->Flash->error(__('The cocktail could not be saved. Please, try again.'));
            }
            $this->set([
                'message' => $message,
                'cocktail' => $cocktail,
            ]);
        }
        $this->viewBuilder()->setOption('serialize', ['cocktail', 'message']);

        $this->set(compact('cocktail'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cocktail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        if ($this->request->is(['patch', 'post', 'put'])) {
            $cocktail = $this->Cocktails->get($id);
            $cocktail = $this->Cocktails->patchEntity($cocktail, $this->request->getData());
            if ($this->Cocktails->save($cocktail)) {
                $message = 'Saved';
                $this->Flash->success(__('The cocktail has been saved.'));
            } else {
                $message = 'Error';
                $this->Flash->error(__('The cocktail could not be saved. Please, try again.'));
            }
            $this->set([
                'message' => $message,
                'cocktail' => $cocktail,
            ]);
            $this->viewBuilder()->setOption('serialize', ['cocktail', 'message']);
        }
        $this->set(compact('cocktail'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cocktail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['delete']);
        $cocktail = $this->Cocktails->get($id);
        $message = 'Deleted';
        $this->Flash->success(__('The cocktail has been deleted.'));
        if (!$this->Cocktails->delete($cocktail)) {
            $message = 'Error';
            $this->Flash->error(__('The cocktail could not be deleted. Please, try again.'));
        }
        $this->set('message', $message);
        $this->viewBuilder()->setOption('serialize', ['message']);

        // return $this->redirect(['action' => 'index']);
    }
}
