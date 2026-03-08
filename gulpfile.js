import gulp from 'gulp';
import cleanCSS from 'gulp-clean-css';
import autoprefixer from 'gulp-autoprefixer';
import uglify from 'gulp-uglify';
import rename from 'gulp-rename';
import concat from 'gulp-concat'; // <-- import concat
import tap from 'gulp-tap';
import path from 'path';

// Minify CSS
export function minifyCss() {
	return gulp.src( ['./assets/**/css/**/*.css', '!./assets/**/css/**/*.min.css'] ) // Exclude already minified files
		.pipe(autoprefixer({
			overrideBrowserslist: ['last 10 versions', '> 0.5%', 'ie 10', 'chrome 28', 'safari 6'],
			cascade: false
		}))
		.pipe( cleanCSS() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( './assets' ) );
}

// Minify JS
export function minifyJs() {
	return gulp.src( ['./assets/**/js/**/*.js', '!./assets/**/js/**/*.min.js'] ) // Exclude already minified files
		.pipe( uglify() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( './assets' ) );
}

// Merge all minified widget CSS into one file
export function mergeWidgetCss() {
	let index = 0;

	return gulp.src(['./assets/css/widgets/**/*.css', '!./assets/css/widgets/**/*.min.css'])
		.pipe(tap(function(file) {

			const name = file.relative.replace(/\\/g, '/');

			const prefix = index === 0 ? '' : '\n'; // blank line except first
			const comment = `${prefix}/* Source: ${name} */\n`;

			file.contents = Buffer.concat([
				Buffer.from(comment),
				file.contents
			]);

			index++;

		}))
		.pipe(concat('widgets-editor.css'))
		.pipe(gulp.dest('./assets/css'))
		.pipe(cleanCSS())
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('./assets/css'));
}

// New task: Minify and rename specific CSS file
// export function minifyZyreIconsCss() {
//     return gulp.src('./assets/fonts/zyre-icons/zyre-icons.css') // Source file
//         .pipe(autoprefixer()) // Add vendor prefixes
//         .pipe(cleanCSS()) // Minify the CSS
//         .pipe(rename({ suffix: '.min' })) // Rename to style.min.css
//         .pipe(gulp.dest('./assets/fonts/zyre-icons')); // Output directory
// }

// Default task
export default gulp.parallel( minifyCss, minifyJs, mergeWidgetCss );
