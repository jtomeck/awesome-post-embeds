# awesome-post-embeds
A WordPress plugin for embedding posts from another Wordpress blog into your site

## Shortcode format
[ape_posts url="YourURLHere.com"]

## Shortcode parameters
* ### url
  (REQUIRED) Enter the URL of the blog that you wish to embed posts from. You must include `http://` or `https://` at the beginning of the URL.

  __Example:__
  ```
  url="http://wordpress.org"
  ```
* ### count
  Enter the number of posts you wish to display. Defaults to 3.

  __Example:__
  ```
  count="5"
  ```
* ### image
  Enter `true` or `false` to determine if the featured image will be displayed or not. Defaults to `true`.

  __Example:__
  ```
  image="false"
  ```
* ### image_size
  Available options include `thumbnail`, `medium`, `medium_large`, `large`, and `full`. Defaults to `full`.

  _NOTE: This is mostly for page speed or image quality purposes as the plugin CSS handles this by default._

  __Example:__
  ```
  excerpt="false"
  ```
* ### tag
  Enter the slug of the tag you want to filter by. Find this by looking at the URL of the tag on the blog you are embedding from. (ie. `http://blogname.com/tag/slug-name`)

  __Example:__
  ```
  tag="tag-slug"
  ```
* ### category
  Enter the slug of the category you want to filter by. Find this by looking at the URL of the tag on the blog you are embedding from. (ie. `http://blogname.com/category/slug-name`)

  __Example:__
  ```
  category="category-slug"
  ```
* ### title
  Enter `true` or `false` to determine if the post title will be displayed or not. Defaults to `true`.

  __Example:__
  ```
  title="false"
  ```
* ### excerpt
  Enter `true` or `false` to determine if the post excerpt will be displayed or not. Defaults to `true`.

  __Example:__
  ```
  excerpt="false"
  ```
* ### new_tab
  Enter `true` or `false` to determine if the link will open in a new tab or not. Defaults to `true`.

  __Example:__
  ```
  new_tab="false"
  ```

## Contributions/Inspirations:
* [Dan LaManna](https://github.com/danlamanna)
