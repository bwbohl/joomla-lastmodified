<?php
/**
 * joomla-lastmodified
 * @copyright Copyright (C) 2026 Benjamin W. Bohl <b.w.bohl@gmail.com>
 * @license   GNU General Public License version 3 or later; see LICENSE
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
 *
 */

namespace Bwbohl\Plugin\Content\LastModified\Extension;

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;

/**
 * LastModified content plugin.
 *
 * Replaces {lastmodified} with the year of the most recently updated article.
 *
 * @since  1.0.0
 */
class LastModified extends CMSPlugin
{
	/**
	 * Replaces {lastmodified} in article text with the year of the last content update.
	 *
	 * @param   string   $context  The context of the content being passed to the plugin.
	 * @param   object   $article  The article object.
	 * @param   object   $params   The article params.
	 * @param   integer  $page     The page number.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		if (strpos($article->text, '{lastmodified}') === false)
		{
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
