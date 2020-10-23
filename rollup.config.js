import md5 from 'md5';
import fs from 'fs-extra';
import babel from '@rollup/plugin-babel';
import alias from '@rollup/plugin-alias';
import filesize from 'rollup-plugin-filesize';
import { terser } from 'rollup-plugin-terser';
import resolve from '@rollup/plugin-node-resolve';
import outputManifest from 'rollup-plugin-output-manifest';

export default {
    input: 'resources/js/index.js',
    output: {
        format: 'umd',
        sourcemap: true,
        name: 'FormComponents',
        file: 'dist/form-components.js',
    },
    plugins: [
        resolve(),
        filesize(),
        terser({
            mangle: false,
            compress: {
                drop_debugger: false,
            },
        }),
        babel({
            exclude: 'node_modules/**',
        }),
        alias({
            entries: [
                { find: '@', replacement: __dirname + '/resources/js' },
            ],
        }),
        // Mimic Laravel Mix's mix-manifest file for auto-cache-busting.
        outputManifest({
            serialize() {
                const file = fs.readFileSync(__dirname + '/dist/form-components.js', 'utf8');
                const hash = md5(file).substr(0, 20);

                return JSON.stringify({
                    '/form-components.js': '/form-components.js?id=' + hash,
                });
            },
        }),
    ],
};
