const handleRequestResponse = (response) => {
    if (!response.ok) {
        throw Error(response.statusText);
    }

    return response.json();
};

export const getImages = ({ token, siteaccess, contentId }, callback) => {
    const body = JSON.stringify({
        ViewInput: {
            identifier: 'images',
            public: false,
            LocationQuery: {
                Criteria: {},
                FacetBuilders: {},
                SortClauses: {},
                Filter: { ContentTypeIdCriterion: 5 },
            },
        },
    });
    const request = new Request('/api/ibexa/v2/views', {
        method: 'POST',
        headers: {
            Accept: 'application/vnd.ibexa.api.View+json; version=1.1',
            'Content-Type': 'application/vnd.ibexa.api.ViewInput+json; version=1.1',
            'X-Siteaccess': siteaccess,
            'X-CSRF-Token': token,
        },
        body,
        mode: 'cors',
    });

    fetch(request)
        .then(handleRequestResponse)
        .then(callback)
        .catch((error) => console.log('error:load:images', error));
};

export const loadImageContent = ({ token, siteaccess, contentId }, callback) => {
    const body = JSON.stringify({
        ViewInput: {
            identifier: `image-content-${contentId}`,
            public: false,
            ContentQuery: {
                Criteria: {},
                FacetBuilders: {},
                SortClauses: {},
                Filter: { ContentIdCriterion: contentId },
            },
        },
    });
    const request = new Request('/api/ibexa/v2/views', {
        method: 'POST',
        headers: {
            Accept: 'application/vnd.ibexa.api.View+json; version=1.1',
            'Content-Type': 'application/vnd.ibexa.api.ViewInput+json; version=1.1',
            'X-Siteaccess': siteaccess,
            'X-CSRF-Token': token,
        },
        body,
        mode: 'cors',
    });

    fetch(request)
        .then(handleRequestResponse)
        .then(callback)
        .catch((error) => console.log('error:load:images', error));
};
