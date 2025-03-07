<?php

namespace Crust\StubConverter\Concerns;

trait FileHelpers
{

    /**
     * Remove/Delete file
     *
     * @param  string  $path
     * @return bool
     */
    protected function removeFile(string $path)
    {
        return unlink($path);
    }


    /**
     * Write to a new file the given content
     *
     * @param  string  $path
     * @param  string  $content
     * 
     * @return bool
     */
    protected function newFileWithContent(string $path, string $content)
    {
        return file_put_contents($path, $content);
    }


    /**
     * Determine if file exists
     *
     * @param  string  $fileFullPath
     * @return bool
     */
    protected function fileExists(string $fileFullPath)
    {
        return file_exists($fileFullPath);
    }


    /**
     * Determine if given path is a directory
     *
     * @param  string  $path
     * @return bool
     */
    protected function isDirectory(string $path)
    {
        return is_dir($path);
    }


    /**
     * Get the fully qualified store path
     *
     * @param  string $path
     * @return string
     */
    protected function getStoreDirectoryPath(string $path)
    {

        if ($this->isDirectory($path)) {

            return $path;
        }

        // Todo: We will look the following code later
        // $path = $this->sanitizePath(str_replace('/public', ('/'. $path), public_path()));

        $path = $this->sanitizePath($path);

        return $path;
    }


    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @param  string|null  $extension
     *
     * @return string
     */
    protected function getPath(string $path, string $name, ?string $extension = 'php')
    {

        $extension = $extension ? ".$extension" : '';

        return $this->sanitizePath($this->getStoreDirectoryPath($path) . '/') . $name . $extension;
    }


    /**
     * Check if target path directory exists or not
     * If not , create the directory in that path
     * And return the final directory path in any case
     *
     * @param  string   $path
     * @param  bool     $fullPath  
     * 
     * @return string
     */
    protected function generateFilePathDirectory(string $path, bool $fullPath = false)
    {

        $directoryPath = $fullPath ? $path : $this->getStoreDirectoryPath($path);

        // Check if the directory exists; if not, create it
        if (!$this->isDirectory($directoryPath)) {
            if (!mkdir($directoryPath, 777, true)) {
                throw new \RuntimeException("Failed to create directory: {$directoryPath}");
            }
        }

        return $directoryPath;
    }


    /**
     * Sanitize the path to proper usable path
     * Remove any unnecessary slashes
     *
     * @param  string $path
     * @return string
     */
    protected function sanitizePath(string $path)
    {

        return preg_replace('#/+#', '/', trim($path) . "/");
    }


    /**
     * Get the content of a given full absolute path of the file
     * Remove any unecessary slashes
     *
     * @param  string $fileFullPath
     * @return string
     */
    protected function getFileContent(string $fileFullPath)
    {
        return file_get_contents($fileFullPath);
    }


    /**
     * Get the full file path from given relative path
     *
     * @param  string $fileRelativePath
     * @return string
     */
    protected function getFileFullPath(string $fileRelativePath)
    {
        // Todo: We will look the following code later
        // return rtrim($this->sanitizePath(str_replace('/public', '', public_path()) . '/' . $fileRelativePath), '/');

        return rtrim($this->sanitizePath($fileRelativePath), '/');
    }
}
