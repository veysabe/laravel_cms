<?php

namespace App\Orchid\Screens\Post;

use App\Models\Element;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PostEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создать пост';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = '';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Post $post): array
    {
        $this->exists = $post->exists;
        $this->post = $post;
        if ($this->exists) {
            $this->name = 'Редактировать пост';
        }
        return [
            'post' => $post
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Добавить пост')
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Применить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->confirm('Данное действие невозможно отменить')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $fields = Layout::rows([
            Input::make('post.name')
            ->title('Название'),
            Code::make('post.json')
            ->title('JSON заглушка')
        ]);
        $banner_fields = [
            Layout::rows([
                Input::make('post.banner.title')
                    ->title('Заголовок'),
                Quill::make('post.banner.text')
                    ->title('Текст'),
                Input::make('post.banner.href')
                    ->title('Ссылка'),
                Input::make('post.banner.button_text')
                    ->title('Текст на кнопке'),
                Picture::make('post.banner.picture')
                    ->title('Фоновое изображение')
            ])
        ];
        $tabs = [
            'Основные поля' => $fields,
            'Баннер' => $banner_fields
        ];
        return [
            Layout::tabs($tabs)
        ];
    }

    public function createOrUpdate(Post $post, Request $request)
    {
        DB::transaction(function () use ($request, $post) {
            $fill = $request->get('post');
            $banner = $fill['banner'];
            unset($fill['banner']);

            $post->fill($fill)->save();

            $post->banner()->delete();
            $post->banner()->updateOrCreate($banner);

        });
        return redirect()->route('platform.post.list');

    }

    public function remove(Post $post)
    {
        $post->delete();

        Alert::info('Вы успешно удалили пост.');

        return redirect()->route('platform.post.list');
    }
}
