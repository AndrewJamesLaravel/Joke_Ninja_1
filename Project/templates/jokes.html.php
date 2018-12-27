<div class="jokelist">

    <ul class="categories">
        <?php foreach ($categories as $category): ?>
            <li><a href="/joke/list?category=<?=$category->id?>"><?=$category->name?></a> </li>
        <?php endforeach; ?>
    </ul>

    <div class="jokes">

<p><?=$totalJokes?> jokes have been submitted to the The Internet Joke Database</p>

<?php foreach ($jokes as $joke): ?>
<blockquote>

        <?=(new \Ninja\MarkDown($joke->joketext))->toHtml()?>

    (by <a href="mailto:<?php echo htmlspecialchars($joke->getAuthor()->email,
            ENT_QUOTES, 'UTF-8'); ?>">
        <?php echo htmlspecialchars($joke->getAuthor()->name,
            ENT_QUOTES, 'UTF-8'); ?></a>
        on <?php
            $date = new DateTime($joke->jokedate);
            echo $date->format('jS F Y');
        ?>)

        <?php if ($user): ?>
            <?php if ($user->id == $joke->authorId || $user->hasPermission(\Jokerdb\Entity\Author::EDIT_JOKES)): ?>
            <a href="/joke/edit?id=<?=$joke->id?>">Edit</a>
            <?php endif; ?>

            <?php if ($user->id == $joke->authorId || $user->hasPermission(\Jokerdb\Entity\Author::DELETE_JOKES)): ?>
            <form action="/joke/delete" method="post">
                <input type="hidden" name="id" value="<?=$joke->id?>">
                <input type="submit" value="Delete">
            </form>
            <?php endif; ?>
        <?php endif; ?>

</blockquote>
<?php endforeach; ?>

        Select page:

        <?php
        $numPages = ceil($totalJokes/10); // calculate the number of pages
        // Display a link for each page
        for ($i = 1; $i <= $numPages; $i++):
            if ($i == $currentPage):
        ?>
        <a class="currentPage" href="/joke/list?page=<?=$i?><?=!empty($categoryId) ? '&category=' . $categoryId : '' ?>"><?=$i?></a>
        <?php else: ?>
        <a href="/joke/list?page=<?=$i?><?=!empty($categoryId) ? '&category=' . $categoryId : '' ?>"><?=$i?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
</div>