<?php

namespace Refaktor\Blog;

class BasicSlugGenerator implements SlugGeneratorInterface {
    public function generateSlug($title) {
        $from = array('á', 'é', 'í', 'ó', 'ú', 'ö', 'ü', 'ő', 'ű');
        $to = array('a', 'e', 'i', 'o', 'u', 'o', 'u', 'o', 'u');

        $slug = mb_strtolower($title);
        $slug = str_replace($from, $to, $slug);
        $slug = \preg_replace('/[^a-zA-Z0-9\/_|+ -]/', '', $slug);
        $slug = \strtolower(\trim($slug, '-'));
        $slug = \preg_replace('/[\/_|+ -]+/', '-', $slug);
        return $slug;
    }
}