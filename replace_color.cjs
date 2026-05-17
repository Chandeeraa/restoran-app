const fs = require('fs');
const path = require('path');

function replaceColors(dir) {
    const files = fs.readdirSync(dir);
    for (const file of files) {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            replaceColors(fullPath);
        } else if (fullPath.endsWith('.blade.php') || fullPath.endsWith('.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            let original = content;
            
            // Replace text-indigo-*, bg-indigo-*, border-indigo-*, ring-indigo-*, from-indigo-*, to-indigo-*
            content = content.replace(/indigo-/g, 'emerald-');
            
            // For blue, replace blue-50, blue-100... up to blue-900 but carefully
            content = content.replace(/\bblue-/g, 'green-');
            
            if (content !== original) {
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log(`Updated: ${fullPath}`);
            }
        }
    }
}

replaceColors(path.join(__dirname, 'resources', 'views'));
replaceColors(path.join(__dirname, 'app', 'Livewire'));
console.log('Replacement complete.');
