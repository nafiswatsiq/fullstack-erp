<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Topic as TopicModel;

class Topic extends Component
{
    use WithFileUploads;
    
    public $name;
    public $description;
    public $image;
    public $category;
    public $filterCategory;
    public $openModal = false;
    public $method = 'create';

    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        'category' => 'required',
    ];

    public function create()
    {
        $this->validate();

        $imageName = md5($this->image . microtime()) . '.' . $this->image->extension();
        $this->image->storeAs('public', $imageName);

        TopicModel::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'category_id' => $this->category,
            'image' => $imageName
        ]);

        $this->reset();
        $this->openModal = false;
    }

    public function edit($id)
    {
        $topic = TopicModel::find($id);

        $this->name = $topic->name;
        $this->description = $topic->description;
        $this->category = $topic->category_id;
        $this->openModal = true;
        $this->method = 'update('.$id.')';
    }

    public function update($id)
    {
        $this->validate();

        $topic = TopicModel::find($id);

        $imageName = $topic->image;

        if ($this->image) {
            $imageName = md5($this->image . microtime()) . '.' . $this->image->extension();
            $this->image->storeAs('public', $imageName);
        }

        $topic->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'category_id' => $this->category,
            'image' => $imageName
        ]);

        $this->reset();
        $this->openModal = false;
        $this->method = 'create';
    }

    public function delete($id)
    {
        $topic = TopicModel::find($id);
        $topic->delete();
    }

    public function render()
    {
        $topics = TopicModel::query()
            ->when($this->filterCategory, function ($query) {
                $query->where('category_id', $this->filterCategory);
            })
            ->get();
        $categories = Category::all();

        return view('livewire.topic', [
            'topics' => $topics,
            'categories' => $categories
        ]);
    }
}
