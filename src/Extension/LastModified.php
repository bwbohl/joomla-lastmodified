<?php
/**
 * joomla-lastmodified
 * Copyright (C) 2026 Benjamin W. Bohl <b.w.bohl@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Bwbohl\Plugin\Content\LastModified\Extension;

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;

class LastModified extends CMSPlugin
{
    public function onContentPrepare($context, &$article, &$params, $page = 0)
    {
        if (strpos($article->text, '{lastmodified}') === false) {
            return;
        }

        $db = $this->getDatabase();
        $query = $db->getQuery(true)
            ->select('MAX(' . $db->quoteName('modified') . ')')
            ->from($db->quoteName('#__content'));
        $db->setQuery($query);
        $lastModified = $db->loadResult();

        $year = date('Y', strtotime($lastModified));
        $article->text = str_replace('{lastmodified}', $year, $article->text);
    }
}
