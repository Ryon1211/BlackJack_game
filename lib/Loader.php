<?php

declare(strict_types=1);

namespace Loader;

class Loader
{
    /**
     * autoloadで読み込みたいファイルがあるディレクトリのリスト
     *
     * @var array<int, string>
     */
    private $directories = [];

    /**
     * コンストラクタ
     *
     * $directoriesにディレクトリの情報を保存
     * registerAutoloadを実行
     *
     * @param string $baseDir
     * @param array<int, string> $directories
     */
    public function __construct(string $baseDir, array $directories)
    {
        foreach ($directories as $dir) {
            $path = "{$baseDir}/{$dir}";
            $this->registerDirectories($path);
        }
        $this->registerAutoload();
    }

    /**
     * $this->directoriesにディレクトリを登録
     *
     * @param string $dir
     * @return void
     */
    public function registerDirectories(string $dir): void
    {
        $this->directories[] = $dir;
    }

    /**
     * spl_autoload_registerのコールバックにに$this->requireClassFile関数を登録する
     *
     * 未定義のクラスが呼ばれたときに、requireClassFileが実行される
     *
     * @return void
     */
    public function registerAutoload(): void
    {
        spl_autoload_register([$this, 'requireClassFile']);
    }

    /**
     * 定義のクラスを呼び出すためのメソッド
     *
     * 引数は呼び出されたクラスの名前空間が自動的に入ってくる
     * （そのままではファイルが呼び出せないので、explodeでクラス名を取り出せるように処理）
     *
     * @param string $namespace
     * @return void
     */
    public function requireClassFile(string $namespace): void
    {
        $explodedNameSpace = explode('\\', $namespace);
        $class = end($explodedNameSpace);
        foreach ($this->directories as $dir) {
            $file = "{$dir}/{$class}.php";

            if (is_readable($file)) {
                require $file;
                return;
            }
        }
    }
}
