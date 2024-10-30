import BaseAIComponent from '../../vendor/ibexa/connector-ai/src/bundle/Resources/public/js/core/base.ai.component';

export default class TranscribeAudio extends BaseAIComponent {
    constructor(mainElement, config) {
        super(mainElement, config);

        this.requestHeaders = {
            Accept: 'application/vnd.ibexa.api.ai.AudioText+json',
            'Content-Type': 'application/vnd.ibexa.api.ai.TranscribeAudio+json',
        };
    }

    getBase64Audio() {
        var request = new XMLHttpRequest();
        request.open('GET', this.inputElement.href, false);
        request.overrideMimeType('text\/plain; charset=x-user-defined');
        request.send();

        if (request.status === 200) {
            var data = request.responseText;
            var binary = ""
            for(var i=0;i<data.length;i++){
                binary += String.fromCharCode(data.charCodeAt(i) & 0xff);
            }

            return btoa(binary);
        }
    }

    getRequestBody() {
        const body = {
            TranscribeAudio: {
                Audio: {
                    base64: this.getBase64Audio(),
                },
                RuntimeContext: {},
            },
        };

        if (this.languageCode) {
            body.TranscribeAudio.RuntimeContext.languageCode = this.languageCode;
        }

        return JSON.stringify(body);
    }

    getResponseValue(response) {
        return response.AudioText.Text.text[0];
    }

    afterFetchData(response) {
        super.afterFetchData();

        if (response) {
            this.outputElement.value = this.getResponseValue(response);
        }
    }

    abortFetch() {
        super.abortFetch();

        this.outputElement.value = this.savePrevValue ? this.prevValue : '';
    }

    toggle(forceEnabled) {
        super.toggle(forceEnabled);

        this.outputElement.disabled = !forceEnabled || !this.outputElement.disabled;
    }
}
