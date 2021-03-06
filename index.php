<?php
/**
 * HTML header
 * header.phpに分割可能
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">

<?php if ( is_active_sidebar( 'head-start' ) ) : ?>
		<?php dynamic_sidebar( 'head-start' ); ?>
<?php endif; ?>

		<meta charset=<?php bloginfo('charset'); ?>>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>?ver=<?php echo date( 'U' ); ?>" type="text/css" media="all" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
	</head>

<?php if ( is_active_sidebar( 'before-body-start' ) ) : ?>
		<?php dynamic_sidebar( 'before-body-start' ); ?>
<?php endif; ?>

<body <?php body_class(); ?>>

<?php
/**
 * グローバルヘッダ
 * header.phpに分割可能
 * トップページはH1, それ以外ではPタグでマークアップ
 */
?>

<header class="global header">
	<?php if ( is_home() || is_front_page() ) : ?>
	<h1>
	<?php else : ?>
	<p>
	<?php endif; ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php if ( has_custom_logo() ) : ?>
		<?php the_custom_logo(); ?>
		<?php else : ?>
		<?php bloginfo( 'name' ); ?>
		<?php endif; ?>
		</a>
	<?php if ( is_home() || is_front_page() ) : ?>
	</h1>
	<?php else : ?>
	</p>
	<?php endif; ?>

	<?php if ( is_archive() ) : ?>
		<h1><?php the_archive_title(); ?>の記事一覧</h1>
	<?php endif; ?>
</header>
<?php
/**
 * コンテンツエリア
 * 構造の共通度に応じて以下のテンプレートに分割可能
 * トップページ: front-page.php > home.php > index.php
 * アーカイブ: category.php > archive.php > index.php
 * 検索: search.php > index.php
 */
?>
<main class="main">

<?php if ( is_404() ) : ?>
		<article>
			<h1 class="title">404 Page Not Found</h1>
		</article>
<?php elseif ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header>
<?php
/**
 * 投稿タイトルの表示
 * 投稿ページと固定ページではH1, それ以外ではH2でマークアップ
 */
?>
				<?php if ( is_single() || is_page() ) : ?>
				<ul class="header-meta">
				<li class="post-date">
					<time datetime="<?php echo get_the_time( 'Y-m-d' ); ?>">
					<?php the_time( 'Y-m-d' ); ?>
					</time>
				</li>
				<?php if ( has_category() ) : ?>
				<li class="post-category"><?php the_category( ', ' ); ?></li>
				<?php endif; ?>
				<?php if ( has_tag() ) : ?>
				<li class="post-tag"><?php the_tags( '', ', ', '' ); ?></li>
				<?php endif; ?>
				</ul>
				<h1 class="title">
					<?php if ( mb_strlen( get_the_title() ) === 0 ) : echo '(no title)' ; else : the_title(); endif; ?>
				</h1>
				<?php else : ?>
				<h2 class="title">
					<a href="<?php the_permalink(); ?>">
						<?php echo mb_substr( get_the_title(), 0, 100 ); ?><?php if ( mb_strlen( get_the_title() ) === 0 ) : echo '(no title)' ; elseif ( mb_strlen( get_the_title() ) >= 100 ) : echo ' ...'; endif; ?>
					</a>
				</h2>
				<?php endif; ?>

			</header>
<?php
/**
 * 投稿内容の表示
 * 投稿ページと固定ページで表示
 */
?>
			<?php if ( is_single() || is_page() ) : ?>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
			<?php the_tags(); ?>
			<?php else : ?>
			<div class="excerpt">
					<?php $str_count = mb_strlen( strip_tags( get_the_content() ) ); ?>
					<?php echo mb_substr( strip_tags( get_the_content() ), 0, 10 ); ?><?php if ( $str_count === 0 ) : echo '(no content)' ; elseif ( $str_count >= 10 ) : echo ' ...'; endif; ?>
					<span class="content-word-count"><?php echo $str_count . 'words.' ?></span>
				</div>
			<?php endif; ?>
<?php
/**
 * コメントの投稿とコメントのリストを表示
 * 投稿ページと固定ページで表示
 */
?>
			<?php if ( is_single() || is_page() ) : ?>
			<ol class="commentlist">
			<?php wp_list_comments(); ?>
			</ol>
			<?php comments_template(); ?>
			<?php paginate_comments_links(); ?>
			<?php endif; ?>

		</article>

<?php endwhile; ?>
<?php else: ?>
<?php endif; ?>

	<nav class="paginate_links">
		<?php echo paginate_links( array(
			'show_all' => true,
		) ); ?>
	</nav>

</main>

<?php
/**
 * サイドバー
 * 一般的にsidebar.phpに含められる
 */
?>
<?php if ( is_active_sidebar( 'sidebar-menu' ) ) : ?>
<aside class="sidebar">
		<?php dynamic_sidebar( 'sidebar-menu' ); ?>
</aside>
<?php endif; ?>


<?php
/**
 * グローバルフッタ
 * 一般的にfooter.phpに含められる
 */
?>
<footer class="global footer">
	<nav>

<?php if ( is_active_sidebar( 'footer-menu' ) ) : ?>
	<div id="footer-menu">
		<?php dynamic_sidebar( 'footer-menu' ); ?>
	</div>
<?php endif; ?>

	</nav>
</footer>
	
<?php wp_footer(); ?>

</body>

<?php if ( is_active_sidebar( 'after-body-end' ) ) : ?>
		<?php dynamic_sidebar( 'after-body-end' ); ?>
<?php endif; ?>

</html>
